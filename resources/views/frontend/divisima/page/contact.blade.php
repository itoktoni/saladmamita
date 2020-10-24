@extends(Helper::setExtendFrontend())

@section('content')

<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Contact</h4>
		<div class="site-pagination">
			<a href="{{ Helper::base_url() }}">Home</a> /
			<a href="{{ route('contact') }}">Contact</a>
		</div>
	</div>
</div>
<!-- Page info end -->

<!-- Contact section -->
<section class="contact-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 contact-info">
				<h3>Get in touch</h3>
				<p>{!! config('website.address') !!}</p>
				<p>{{ config('website.phone') }}</p>
				<p>{{ config('website.email') }}</p>

				{!!Form::open(['route' => 'contact', 'class' => 'contact-form']) !!}
				<input type="text" class="{{ $errors->has('marketing_contact_name') ? 'error' : ''}}" value="{{ old('marketing_contact_name') ?? null }}" name="marketing_contact_name" placeholder="Your name">
				<input type="text" class="{{ $errors->has('marketing_contact_email') ? 'error' : ''}}" value="{{ old('marketing_contact_email') ?? null }}" name="marketing_contact_email" placeholder="Your e-mail">
				<input type="text" class="{{ $errors->has('marketing_contact_phone') ? 'error' : ''}}" value="{{ old('marketing_contact_phone') ?? null }}" name="marketing_contact_phone" placeholder="Phone">
				<input type="text" class="{{ $errors->has('marketing_contact_subject') ? 'error' : ''}}" value="{{ old('marketing_contact_subject') ?? null }}" name="marketing_contact_subject" placeholder="Subject">
				<textarea class="{{ $errors->has('marketing_contact_message') ? 'error' : ''}}" name="marketing_contact_message" placeholder="Message">{{ old('marketing_contact_message') ?? null }}</textarea>
				<button type="submit" class="site-btn">SEND NOW</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="map">
		<iframe
			src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14376.077865872314!2d-73.879277264103!3d40.757667781624285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1546528920522"
			style="border:0" allowfullscreen>
		</iframe>
	</div>
</section>
<!-- Contact section end -->

<!-- Related product section end -->
@endsection