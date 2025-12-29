@extends('Frontend.layouts.app')
@section('subscription-active', 'active')
@section('title', __('Subscription'))
@push('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 40px;
            color: #333;
            line-height: 1.6;
        }

        h1,
        h2,
        h3 {
            color: #004466;
        }

        a {
            color: #006699;
            text-decoration: none;
        }
    </style>
@endpush
@section('content')
    <h1>Privacy Policy</h1>
    {{-- <p><strong>Effective Date:</strong> [Insert Date]</p> --}}
    <p>
        Welcome to <strong>Koncite</strong>. This Privacy Policy explains how we collect, use,
        disclose, and safeguard your information when you visit our website and use our
        services, including the <em>Koncite Construction Management App</em>.
    </p>

    <h2>1. Information We Collect</h2>
    <h3>a. Personal Information</h3>
    <ul>
        <li>Name</li>
        <li>Email address</li>
        <li>Phone number</li>
        <li>Company name</li>
        <li>Job role or title</li>
        <li>Billing information (if applicable)</li>
    </ul>

    <h3>b. Usage Data</h3>
    <ul>
        <li>IP address</li>
        <li>Browser type</li>
        <li>Device information</li>
        <li>Pages visited</li>
        <li>Access times</li>
        <li>Referral URLs</li>
    </ul>

    <h3>c. Project & Business Data</h3>
    <ul>
        <li>Project details</li>
        <li>Task assignments</li>
        <li>Team member information</li>
        <li>Files, documents, and photos</li>
        <li>Inventory and vendor data</li>
    </ul>

    <h2>2. How We Use Your Information</h2>
    <ul>
        <li>Provide and maintain our services</li>
        <li>Improve user experience and support</li>
        <li>Send administrative notifications</li>
        <li>Respond to inquiries or issues</li>
        <li>Analyze usage to enhance performance</li>
        <li>Manage subscriptions or transactions</li>
    </ul>

    <h2>3. Sharing of Information</h2>
    <ul>
        <li><strong>Service Providers</strong>: To assist with hosting, analytics, etc.</li>
        <li><strong>Legal Requirements</strong>: To comply with applicable laws</li>
        <li><strong>Business Transfers</strong>: In case of merger or acquisition</li>
    </ul>

    <h2>4. Data Security</h2>
    <p>We use industry-standard measures to secure your information but cannot guarantee complete safety online.</p>

    <h2>5. Your Rights & Choices</h2>
    <p>You can request access, updates, deletion, or a copy of your data. Contact us at <a
            href="mailto:info@koncite.com">info@koncite.com</a>.</p>

    <h2>6. Cookies & Tracking Technologies</h2>
    <p>We use cookies for analytics and functionality. You may disable cookies via your browser settings.</p>

    <h2>7. Third-Party Links</h2>
    <p>We are not responsible for the content or privacy policies of third-party websites linked from our platform.</p>

    <h2>8. Children’s Privacy</h2>
    <p>Our services are not intended for children under 16, and we do not knowingly collect their data.</p>

    <h2>9. Changes to This Policy</h2>
    <p>We may revise this policy periodically. Changes will be posted on this page with an updated effective date.</p>

    <h2>10. Contact Us</h2>
    <p>
        <strong>Koncite Technologies Pvt. Ltd.</strong><br />
        Email: <a href="mailto:info@koncite.com">info@koncite.com</a><br />
        Website: <a href="https://www.koncite.com" target="_blank">www.koncite.com</a>
    </p>
@endsection

@push('scripts')
@endpush
