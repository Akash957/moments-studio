@extends('layouts.app')
@php
    $seoTitle = 'Book Your Photography Session — Moments Studio';
    $seoDescription = 'Reserve your wedding date with Moments Studio. Easy online multi-step booking process for photography and videography.';
@endphp

@section('content')

{{-- Hero --}}
<section class="page-hero" style="background-image: linear-gradient(180deg, rgba(15,15,15,0.7) 0%, rgba(15,15,15,0.95) 100%), url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1920'); padding: 130px 0 70px;">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label">Online Reservation</span>
            <h1 class="page-hero-title">Book Your Date</h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">Booking</span>
            </nav>
        </div>
    </div>
</section>

{{-- Multi Step Booking --}}
<section class="section section-dark" x-data="bookingForm({{ json_encode([
    'package_id' => $selectedPackage->id ?? '',
    'event_type' => $selectedPackage->service->name ?? ($selectedPackage ? 'Wedding Photography' : '')
]) }})">
    <div class="container" style="max-width:900px;">

        {{-- Step Indicator --}}
        <div class="booking-steps">
            <div class="booking-step" :class="{ active: currentStep === 1, done: currentStep > 1 }">
                <div class="booking-step-circle">1</div>
                <div class="booking-step-line"></div>
            </div>
            <div class="booking-step" :class="{ active: currentStep === 2, done: currentStep > 2 }">
                <div class="booking-step-circle">2</div>
                <div class="booking-step-line"></div>
            </div>
            <div class="booking-step" :class="{ active: currentStep === 3, done: currentStep > 3 }">
                <div class="booking-step-circle">3</div>
                <div class="booking-step-line"></div>
            </div>
            <div class="booking-step" :class="{ active: currentStep === 4, done: currentStep === 4 }">
                <div class="booking-step-circle">4</div>
            </div>
        </div>

        <div class="contact-card p-4 p-md-5">

            <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" id="bookingForm" @submit.prevent="submitForm()">
                @csrf

                {{-- Step 1: Select Event & Package --}}
                <div x-show="currentStep === 1" x-transition>
                    <span class="section-label">Step 1 of 4</span>
                    <h3 class="section-title mb-4" style="font-size:1.75rem;">Choose Event Type & Service</h3>

                    <div class="form-group mb-4">
                        <label class="form-label">Event Type *</label>
                        <select name="event_type" class="form-control" x-model="form.event_type" required>
                            <option value="">-- Select Event Type --</option>
                            @foreach($services as $srv)
                            <option value="{{ $srv->name }}">{{ $srv->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Select Package (Optional)</label>
                        <select name="package_id" class="form-control" x-model="form.package_id">
                            <option value="">-- Custom Coverage --</option>
                            @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}" {{ isset($selectedPackage) && $selectedPackage->id == $pkg->id ? 'selected' : '' }}>
                                {{ $pkg->name }} — ₹{{ number_format($pkg->price, 0) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-primary" @click="nextStep()" :disabled="!form.event_type">
                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 2: Date & Location Details --}}
                <div x-show="currentStep === 2" x-transition style="display:none;">
                    <span class="section-label">Step 2 of 4</span>
                    <h3 class="section-title mb-4" style="font-size:1.75rem;">Date, Time & Location</h3>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Event Date *</label>
                                <input type="date" name="event_date" class="form-control" x-model="form.event_date" min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Preferred Time Slot / Hours</label>
                                <input type="text" name="event_time" class="form-control" x-model="form.event_time" placeholder="e.g. Full Day, Morning Session, 10 AM - 6 PM">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Venue / Location *</label>
                                <input type="text" name="event_location" class="form-control" x-model="form.event_location" placeholder="Hotel / Resort / Palace Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">City *</label>
                                <input type="text" name="event_city" class="form-control" x-model="form.event_city" placeholder="e.g. Mumbai, Udaipur, Goa">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Expected Guest Count</label>
                                <input type="number" name="guest_count" class="form-control" x-model="form.guest_count" placeholder="e.g. 250">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline" @click="prevStep()">
                            <i class="fas fa-arrow-left me-2"></i> Previous
                        </button>
                        <button type="button" class="btn btn-primary" @click="nextStep()" :disabled="!form.event_date || !form.event_location">
                            Next Step <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 3: Contact Details --}}
                <div x-show="currentStep === 3" x-transition style="display:none;">
                    <span class="section-label">Step 3 of 4</span>
                    <h3 class="section-title mb-4" style="font-size:1.75rem;">Your Contact Information</h3>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Your Name *</label>
                                <input type="text" name="client_name" class="form-control" x-model="form.client_name" placeholder="Full Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="client_email" class="form-control" x-model="form.client_email" placeholder="your@email.com" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" name="client_phone" class="form-control" x-model="form.client_phone" placeholder="+91 XXXXX XXXXX" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Special Requirements / Notes</label>
                                <input type="text" name="special_requirements" class="form-control" x-model="form.special_requirements" placeholder="Theme, drones, album preferences...">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline" @click="prevStep()">
                            <i class="fas fa-arrow-left me-2"></i> Previous
                        </button>
                        <button type="button" class="btn btn-primary" @click="nextStep()" :disabled="!form.client_name || !form.client_email || !form.client_phone">
                            Review & Confirm <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 4: Summary & Submit --}}
                <div x-show="currentStep === 4" x-transition style="display:none;">
                    <span class="section-label">Step 4 of 4</span>
                    <h3 class="section-title mb-4" style="font-size:1.75rem;">Review Your Reservation</h3>

                    <div style="background:var(--color-dark-3);border:1px solid var(--color-gold-fade);border-radius:var(--radius-lg);padding:1.5rem;" class="mb-4">
                        <div class="row g-3">
                            <div class="col-6"><strong class="text-gold">Event Type:</strong> <span class="text-white" x-text="form.event_type"></span></div>
                            <div class="col-6"><strong class="text-gold">Date:</strong> <span class="text-white" x-text="form.event_date"></span></div>
                            <div class="col-6"><strong class="text-gold">Location:</strong> <span class="text-white" x-text="form.event_location"></span></div>
                            <div class="col-6"><strong class="text-gold">Client Name:</strong> <span class="text-white" x-text="form.client_name"></span></div>
                            <div class="col-6"><strong class="text-gold">Email:</strong> <span class="text-white" x-text="form.client_email"></span></div>
                            <div class="col-6"><strong class="text-gold">Phone:</strong> <span class="text-white" x-text="form.client_phone"></span></div>
                        </div>
                    </div>

                    <p style="font-size:0.8125rem;color:var(--color-gray);" class="mb-4">
                        By submitting this reservation request, our studio manager will verify availability for your specified date and reach out via Phone/WhatsApp within 24 hours.
                    </p>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline" @click="prevStep()">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </button>
                        <button type="submit" class="btn btn-primary" :disabled="submitting">
                            <span x-show="!submitting"><i class="fas fa-check-circle me-2"></i> Confirm Booking</span>
                            <span x-show="submitting"><i class="fas fa-spinner fa-spin me-2"></i> Processing...</span>
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</section>

@endsection
