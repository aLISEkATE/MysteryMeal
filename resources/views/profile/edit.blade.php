<x-app-layout>


    <style>
        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 32px;
        }
        
        .profile-card {
            background: white;
            border-radius: 24px;
            border: 1px solid #ffe3ec;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 24px 48px rgba(0,0,0,0.08);
        }
        
        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ff6b8b;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #ffe3ec;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }
        
        input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            font-size: 1rem;
            transition: all 0.2s;
        }
        
        input:focus {
            outline: none;
            border-color: #ff8fb1;
            box-shadow: 0 0 0 3px rgba(255,143,177,0.1);
        }
        
        .btn-primary {
            background: #ff6b8b;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 9999px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background: #ff5a7a;
            transform: scale(1.02);
        }
        
        .btn-danger {
            background: #ef4444;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 9999px;
            font-weight: 600;
            cursor: pointer;
        }
        
        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        
        .current-info {
            background: #f8fafc;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #6b7280;
        }
        
        .info-value {
            color: #ff6b8b;
            font-weight: 500;
        }
    </style>

    <div class="profile-container">
        @if(session('status') === 'profile-updated')
            <div class="success-message">✅ Profile updated successfully!</div>
        @endif

        @if(session('status') === 'password-updated')
            <div class="success-message">✅ Password updated successfully!</div>
        @endif

        <!-- Current Info Card -->
        <div class="profile-card">
            <h3 class="card-title">📋 Current Information</h3>
            <div class="current-info">
                <div class="info-row">
                    <span class="info-label">Username:</span>
                    <span class="info-value">{{ Auth::user()->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ Auth::user()->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Member since:</span>
                    <span class="info-value">{{ Auth::user()->created_at->format('F j, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Update Profile Form -->
        <div class="profile-card">
            <h3 class="card-title">✏️ Update Profile</h3>
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password Form -->
        <div class="profile-card">
            <h3 class="card-title">🔐 Update Password</h3>
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account -->
        <div class="profile-card">
            <h3 class="card-title">⚠️ Danger Zone</h3>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>