(function () {
    'use strict';

    const root = document.getElementById('guidedInstructorPlayer');
    const manifestNode = document.getElementById('guidedInstructorManifest');
    if (!root || !manifestNode) return;

    let manifest;
    try { manifest = JSON.parse(manifestNode.textContent); } catch (error) { return; }
    if (!Array.isArray(manifest.segments) || !manifest.segments.length) return;

    const audio = document.getElementById('guidedInstructorAudio');
    const play = document.getElementById('guidedPlay');
    const seek = document.getElementById('guidedSeek');
    const elapsed = document.getElementById('guidedElapsed');
    const duration = document.getElementById('guidedDuration');
    const state = document.getElementById('guidedInstructorState');
    const currentTitle = document.getElementById('guidedCurrentSegment');
    const speed = document.getElementById('guidedSpeed');
    const mute = document.getElementById('guidedMute');
    const transcript = document.getElementById('guidedTranscript');
    const transcriptToggle = document.getElementById('guidedTranscriptToggle');
    const resumeBox = document.getElementById('guidedResume');
    const resumeTime = document.getElementById('guidedResumeTime');
    const storageKey = ['mupo_guided_audio', root.dataset.userId, root.dataset.courseId, root.dataset.lessonId].join('_');
    let segmentIndex = 0;
    let pendingResume = null;
    let saveTimer = null;

    const formatTime = (seconds) => {
        const safe = Number.isFinite(seconds) ? Math.max(0, seconds) : 0;
        const minutes = Math.floor(safe / 60);
        return String(minutes).padStart(2, '0') + ':' + String(Math.floor(safe % 60)).padStart(2, '0');
    };
    const audioUrl = (segment) => {
        const file = String(segment.audio || '').replace(/^\/+/, '');
        return String(manifest.base_url || '').replace(/\/$/, '') + '/' + file.split('/').map(encodeURIComponent).join('/');
    };
    const totalBefore = (index) => manifest.segments.slice(0, index).reduce((sum, item) => sum + Number(item.duration || 0), 0);
    const totalDuration = () => manifest.segments.reduce((sum, item) => sum + Number(item.duration || 0), 0);

    function highlight(index) {
        document.querySelectorAll('[data-guided-segment]').forEach((item) => item.classList.toggle('is-active', Number(item.dataset.guidedSegment) === index));
        document.querySelectorAll('.guided-section-active').forEach((item) => item.classList.remove('guided-section-active'));
        const segment = manifest.segments[index];
        if (!segment) return;
        currentTitle.textContent = segment.title || 'Lesson segment';
        const sectionId = segment.section_id || segment.id;
        if (sectionId) {
            let target = document.getElementById(sectionId);
            if (!target) {
                const normalizedTitle = String(segment.title || '').trim().toLowerCase();
                target = Array.from(document.querySelectorAll('.lesson_content_text h1, .lesson_content_text h2, .lesson_content_text h3, .lesson_content_text h4'))
                    .find((heading) => heading.textContent.trim().toLowerCase() === normalizedTitle);
            }
            if (target && !target.closest('.guided-instructor')) target.classList.add('guided-section-active');
        }
    }

    function loadSegment(index, shouldPlay, atTime) {
        if (index < 0 || index >= manifest.segments.length) return;
        segmentIndex = index;
        highlight(index);
        audio.src = audioUrl(manifest.segments[index]);
        audio.playbackRate = Number(speed.value);
        audio.addEventListener('loadedmetadata', function positionOnce() {
            audio.removeEventListener('loadedmetadata', positionOnce);
            if (Number.isFinite(atTime) && atTime > 0) audio.currentTime = Math.min(atTime, Math.max(0, audio.duration - .25));
            if (shouldPlay) audio.play().catch(showPlaybackError);
            renderProgress();
        });
        audio.load();
    }

    function showPlaybackError() {
        root.classList.remove('is-playing');
        state.innerHTML = '<i></i> Audio unavailable';
        play.querySelector('span').textContent = 'Try Again';
    }

    function renderProgress() {
        const knownTotal = totalDuration();
        const segmentDuration = Number.isFinite(audio.duration) ? audio.duration : Number(manifest.segments[segmentIndex].duration || 0);
        const absolute = totalBefore(segmentIndex) + (audio.currentTime || 0);
        const total = knownTotal || (totalBefore(segmentIndex) + segmentDuration);
        elapsed.textContent = formatTime(absolute);
        duration.textContent = formatTime(total);
        seek.value = total > 0 ? Math.min(1000, Math.round((absolute / total) * 1000)) : 0;
    }

    function savePosition() {
        const payload = { segment: segmentIndex, time: audio.currentTime || 0, updated_at: Date.now() };
        try { localStorage.setItem(storageKey, JSON.stringify(payload)); } catch (error) {}
    }

    audio.addEventListener('play', () => { root.classList.add('is-playing'); state.innerHTML = '<i></i> Playing'; play.innerHTML = '<i class="fas fa-pause"></i><span>Pause</span>'; });
    audio.addEventListener('pause', () => { root.classList.remove('is-playing'); state.innerHTML = '<i></i> Paused'; play.innerHTML = '<i class="fas fa-play"></i><span>Continue</span>'; savePosition(); });
    audio.addEventListener('timeupdate', () => { renderProgress(); clearTimeout(saveTimer); saveTimer = setTimeout(savePosition, 400); });
    audio.addEventListener('ended', () => {
        if (segmentIndex < manifest.segments.length - 1) loadSegment(segmentIndex + 1, true, 0);
        else { root.classList.remove('is-playing'); state.innerHTML = '<i></i> Finished'; play.innerHTML = '<i class="fas fa-redo"></i><span>Listen Again</span>'; try { localStorage.removeItem(storageKey); } catch (error) {} }
    });
    audio.addEventListener('error', showPlaybackError);
    play.addEventListener('click', () => {
        if (!audio.src || (audio.ended && segmentIndex === manifest.segments.length - 1)) loadSegment(0, true, 0);
        else if (audio.paused) audio.play().catch(showPlaybackError); else audio.pause();
    });
    document.querySelectorAll('[data-guided-seek]').forEach((button) => button.addEventListener('click', () => {
        const target = Math.max(0, totalBefore(segmentIndex) + (audio.currentTime || 0) + Number(button.dataset.guidedSeek));
        seekToAbsolute(target, !audio.paused);
    }));
    function seekToAbsolute(target, shouldPlay) {
        let remaining = target;
        for (let index = 0; index < manifest.segments.length; index++) {
            const length = Number(manifest.segments[index].duration || 0);
            if (!length || remaining <= length || index === manifest.segments.length - 1) { loadSegment(index, shouldPlay, Math.max(0, remaining)); return; }
            remaining -= length;
        }
    }
    seek.addEventListener('input', () => seekToAbsolute((Number(seek.value) / 1000) * totalDuration(), !audio.paused));
    speed.addEventListener('change', () => { audio.playbackRate = Number(speed.value); });
    mute.addEventListener('click', () => { audio.muted = !audio.muted; mute.innerHTML = audio.muted ? '<i class="fas fa-volume-mute"></i>' : '<i class="fas fa-volume-up"></i>'; mute.setAttribute('aria-label', audio.muted ? 'Unmute guided lesson' : 'Mute guided lesson'); });
    transcriptToggle.addEventListener('click', () => { const open = transcript.hidden; transcript.hidden = !open; transcriptToggle.setAttribute('aria-expanded', String(open)); });
    document.querySelectorAll('[data-guided-segment]').forEach((item) => item.addEventListener('click', () => loadSegment(Number(item.dataset.guidedSegment), true, 0)));

    try {
        const saved = JSON.parse(localStorage.getItem(storageKey) || 'null');
        if (saved && Number(saved.segment) >= 0 && (Number(saved.segment) > 0 || Number(saved.time) > 5)) {
            pendingResume = saved;
            resumeTime.textContent = formatTime(totalBefore(Number(saved.segment)) + Number(saved.time || 0));
            resumeBox.hidden = false;
        }
    } catch (error) {}
    resumeBox.querySelectorAll('[data-resume-action]').forEach((button) => button.addEventListener('click', () => {
        const resume = button.dataset.resumeAction === 'resume' && pendingResume;
        resumeBox.hidden = true;
        loadSegment(resume ? Number(pendingResume.segment) : 0, true, resume ? Number(pendingResume.time || 0) : 0);
    }));

    highlight(0);
    renderProgress();
})();
