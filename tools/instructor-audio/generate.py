#!/usr/bin/env python3
"""Generate approved MUPO Guided Instructor segments locally with Chatterbox."""

import argparse
import json
import shutil
import subprocess
import sys
from pathlib import Path


def arguments():
    parser = argparse.ArgumentParser(description="Generate approved MUPO instructor audio once, offline.")
    parser.add_argument("--scripts", default="storage/app/guided-instructor/scripts")
    parser.add_argument("--output", default="public/storage/instructor-audio")
    parser.add_argument("--device", choices=("auto", "cpu", "cuda", "mps"), default="auto")
    parser.add_argument("--voice", help="Optional approved voice-reference WAV file")
    parser.add_argument("--force", action="store_true", help="Regenerate existing MP3 files")
    parser.add_argument("--dry-run", action="store_true", help="Validate approved scripts without loading the model")
    return parser.parse_args()


def select_device(requested, torch):
    if requested != "auto":
        return requested
    if torch.cuda.is_available():
        return "cuda"
    if getattr(torch.backends, "mps", None) and torch.backends.mps.is_available():
        return "mps"
    return "cpu"


def approved_payload(path):
    data = json.loads(path.read_text(encoding="utf-8"))
    if data.get("approved") is not True:
        return None
    segments = data.get("segments") or []
    if not segments or any(segment.get("approved") is not True for segment in segments):
        raise ValueError(f"{path}: every segment must have approved=true")
    if any(not str(segment.get("text", "")).strip() for segment in segments):
        raise ValueError(f"{path}: every approved segment needs text")
    return data


def ffmpeg_mp3(source, destination):
    command = ["ffmpeg", "-y", "-loglevel", "error", "-i", str(source), "-ac", "1", "-ar", "24000", "-b:a", "80k", str(destination)]
    subprocess.run(command, check=True)


def ffprobe_duration(path):
    result = subprocess.run(
        ["ffprobe", "-v", "error", "-show_entries", "format=duration", "-of", "default=nw=1:nk=1", str(path)],
        check=True, capture_output=True, text=True,
    )
    return round(float(result.stdout.strip()), 3)


def main():
    args = arguments()
    root = Path.cwd()
    scripts = (root / args.scripts).resolve()
    output = (root / args.output).resolve()
    files = sorted(scripts.glob("course-*/lesson-*.json"))
    if not files:
        raise SystemExit(f"No exported scripts found below {scripts}")
    if not shutil.which("ffmpeg") or not shutil.which("ffprobe"):
        raise SystemExit("ffmpeg and ffprobe must be installed and available in PATH")

    approved = []
    for path in files:
        try:
            payload = approved_payload(path)
            if payload:
                approved.append((path, payload))
        except (ValueError, json.JSONDecodeError) as error:
            print(f"ERROR: {error}", file=sys.stderr)
            return 2
    print(f"Validated {len(approved)} approved script(s); {len(files) - len(approved)} awaiting review.")
    if args.dry_run or not approved:
        return 0

    import torch
    import torchaudio
    from chatterbox.tts import ChatterboxTTS

    device = select_device(args.device, torch)
    print(f"Loading Chatterbox on {device}...")
    model = ChatterboxTTS.from_pretrained(device=device)
    voice = str(Path(args.voice).resolve()) if args.voice else None

    for source_path, payload in approved:
        course_id = int(payload["course_id"])
        lesson_id = int(payload["lesson_id"])
        destination = output / f"course-{course_id}" / f"lesson-{lesson_id}"
        destination.mkdir(parents=True, exist_ok=True)
        manifest_segments = []

        for number, segment in enumerate(payload["segments"], start=1):
            segment_id = str(segment.get("id") or f"segment-{number}")
            mp3_name = f"{number:02d}-{segment_id}.mp3"
            mp3_path = destination / mp3_name
            wav_path = destination / f".{number:02d}-{segment_id}.wav"
            if args.force or not mp3_path.exists():
                options = {"audio_prompt_path": voice} if voice else {}
                waveform = model.generate(
                    str(segment["text"]),
                    use_auto_editor=True,
                    ae_threshold=0.06,
                    ae_margin=0.2,
                    **options,
                )
                torchaudio.save(str(wav_path), waveform, model.sr)
                ffmpeg_mp3(wav_path, mp3_path)
                wav_path.unlink(missing_ok=True)
            manifest_segments.append({
                "id": segment_id,
                "section_id": segment.get("section_id"),
                "title": segment.get("title") or f"Segment {number}",
                "audio": mp3_name,
                "duration": ffprobe_duration(mp3_path),
                "transcript": segment["text"],
            })

        manifest = {
            "schema_version": 1,
            "course_id": course_id,
            "lesson_id": lesson_id,
            "title": f"{payload.get('lesson_title', 'Lesson')} — Guided Lesson",
            "description": "Your MUPO instructor explains this lesson using practical examples and important takeaways.",
            "language": payload.get("language", "en-ZA"),
            "segments": manifest_segments,
        }
        (destination / "manifest.json").write_text(json.dumps(manifest, ensure_ascii=False, indent=2), encoding="utf-8")
        print(f"Generated course {course_id}, lesson {lesson_id}: {len(manifest_segments)} segment(s)")

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
