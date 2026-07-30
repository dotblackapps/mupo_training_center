@extends(theme('layouts.mupo'))
@section('title', (Settings('site_title') ?: 'Mupo Training Center') . ' | Contact Us')
@section('mainContent')
<section class="page-hero"><div><small>Contact Us</small><h1>Ready to Start Your Learning Journey?</h1><p>Complete the enquiry form and our team will contact you.</p></div></section><section class="section contact-layout"><div><p class="eyebrow">Contact Us</p><h2>Ready to Start Your Learning Journey?</h2><p>Complete the enquiry form and our team will contact you.</p><ul class="contact-list"><li><i class="fa-solid fa-phone"></i> 012 004 2004 / 084 750 7013</li><li><i class="fa-solid fa-envelope"></i> admin@mupotrainingcenter.co.za</li><li><i class="fa-solid fa-globe"></i> www.mupotrainingcenter.co.za</li><li><i class="fa-solid fa-location-dot"></i> 377 Johannes Ramokhoase Street, Pretoria Central 0002</li>

<div class="mupo-contact-map">
    <iframe
        title="Mupo Training Center Map - 377 Johannes Ramokhoase Street, Pretoria Central, 0002"
        src="https://www.google.com/maps?q=377%20Johannes%20Ramokhoase%20Street%2C%20Pretoria%20Central%2C%200002&output=embed"
        width="100%"
        height="100%"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
</ul></div><form class="contact-form" method="POST" action="{{ route('contactMsgSubmit') }}">
@csrf<input type="text" placeholder="Full Name" required><input type="email" placeholder="Email Address" required><input type="tel" placeholder="Phone Number"><input type="text" placeholder="Organisation"><select required><option value="">Select Course Interest</option><option>Security & Protection</option><option>Firearm & Competency</option><option>Office Administration</option><option>Data Science</option><option>Project Management</option><option>Corporate Training</option></select><textarea placeholder="Message"></textarea><button class="btn" type="submit">Submit Enquiry</button></form></section><section class="section white">
</section>

<style>
.mupo-map-wrap{
    width:100%;
    min-height:420px;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 18px 45px rgba(6,23,56,.12);
    border:1px solid #e5eaf2;
    background:#fff;
}
</style>


<style>
.mupo-contact-map{
    width:100%;
    height:360px;
    min-height:360px;
    margin-top:24px;
    border-radius:22px;
    overflow:hidden;
    border:1px solid #e5eaf2;
    box-shadow:0 18px 45px rgba(6,23,56,.12);
    background:#fff;
}
.mupo-contact-map iframe{
    display:block;
    width:100%;
    height:100%;
}
@media(max-width:900px){
    .mupo-contact-map{
        height:320px;
        min-height:320px;
    }
}
</style>

@endsection
