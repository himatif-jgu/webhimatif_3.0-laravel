# Profile & Member Edit - Noble UI Implementation

## 📋 Overview
Halaman profile dan edit member telah diubah menggunakan template **Noble UI** (Bootstrap 5) dengan fitur image crop menggunakan Cropper.js dan Sweet Alert 2 untuk notifikasi.

## ✅ Perubahan Utama

### 1. **Pemisahan View & Edit Profile**
- **View Profile** (`/profile`) - Read-only untuk melihat profile
- **Edit Profile** (`/profile/edit`) - Form edit dengan crop feature
- Kedua halaman menggunakan **Noble UI template**

### 2. **Template Migration**
- ❌ **Sebelumnya**: Menggunakan Breeze (Tailwind CSS)
- ✅ **Sekarang**: Menggunakan Noble UI (Bootstrap 5)
- Konsistensi dengan admin template

### 3. **Image Crop Feature**
- Upload avatar dengan preview
- Crop gambar 1:1 ratio
- High quality output (400x400px)
- Support JPG, PNG, GIF (max 2MB)

### 4. **Sweet Alert Integration**
- Success notifications
- Error alerts
- Warning confirmations
- Toast notifications

## 📁 Files Created/Modified

### Created Files:
1. **resources/views/profile/show.blade.php** - View profile (read-only)
2. **resources/views/profile/edit.blade.php** - Edit profile dengan Noble UI
3. **resources/views/admin/members/edit.blade.php** - Edit member dengan Noble UI + crop
4. **PROFILE_NOBLE_UI_CHANGES.md** - Dokumentasi ini

### Modified Files:
1. **app/Http/Controllers/ProfileController.php**
   - Added `show()` method untuk view profile
   - Updated `update()` untuk handle base64 cropped image

2. **app/Http/Controllers/Admin/MemberController.php**
   - Updated `update()` untuk handle base64 cropped image

3. **app/Http/Requests/UpdateMemberRequest.php**
   - Added `avatar_base64` validation

4. **routes/web.php**
   - Added `GET /profile` → ProfileController@show
   - Changed `GET /profile/edit` → ProfileController@edit

## 🎨 View Profile Features

### Layout:
- **Left Column (4 cols)**:
  - Avatar (160x160px circular)
  - Name, email, username
  - Role badges
  - Online status with last seen
  - Edit Profile button
  - Social media links (Instagram, LinkedIn, Website)
  - Quick Info card (Status, Division, Batch, Last Seen)

- **Right Column (8 cols)**:
  - Personal Information (read-only display)
  - Change Password card
  - Delete Account card (danger zone)

### Features:
- ✅ Clean, professional UI
- ✅ Responsive layout
- ✅ Social media icons with Lucide
- ✅ Status badges (Active/Inactive)
- ✅ Online status indicator
- ✅ Modal untuk delete account confirmation

## 🎨 Edit Profile Features

### Layout:
- **Left Column (4 cols)**:
  - Avatar upload dengan crop
  - Camera button overlay
  - Remove photo button
  - Online status display
  - JPG/PNG/GIF info

- **Right Column (8 cols)**:
  - **Personal Information Card**:
    - Full Name, Username (required)
    - Email, Phone
    - Student Number, Batch Year
    - Gender, Birth Date
    - Address, Bio
  
  - **Social Links Card**:
    - Instagram, LinkedIn, Website
    - Icon prefix untuk setiap input

  - **Actions Card**:
    - Cancel & Save buttons

  - **Bottom Section**:
    - Change Password form
    - Delete Account form

### Avatar Upload Flow:
1. Click avatar atau camera button
2. Select image (max 2MB)
3. **Crop Modal** muncul dengan Cropper.js
4. Drag & resize crop area
5. Click "Apply" → Preview updated
6. Click "Save Changes" → Upload ke server

### Remove Avatar:
1. Click "Remove Photo"
2. **Sweet Alert** confirmation
3. Avatar → Default UI Avatar
4. Click "Save Changes" → Remove dari server

## 🎨 Edit Member (Admin) Features

### Layout:
Same as Edit Profile dengan beberapa perbedaan:
- Added **Membership Role** dropdown
- Added **Division** dropdown
- Added **Status Aktif** toggle switch
- Different breadcrumb (Admin → Anggota → Edit)
- Different action buttons (Batal & Simpan Perubahan)

### Additional Features:
- Admin bisa edit semua member
- Toggle active status
- Assign role & division
- Same crop feature untuk avatar

## 🔧 Technical Implementation

### Backend Changes:

#### ProfileController.php:
```php
// New method
public function show(Request $request): View
{
    return view('profile.show', ['user' => $request->user()]);
}

// Updated update method
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    // Handle avatar_file (normal upload)
    if ($request->hasFile('avatar_file')) {
        // Store file, delete old
    }
    // Handle avatar (base64 from crop)
    elseif ($request->has('avatar') && str_starts_with($request->avatar, 'data:image')) {
        // Decode base64, save as PNG
    }
}
```

#### MemberController.php:
```php
public function update(UpdateMemberRequest $request, User $member)
{
    // Handle avatar (normal upload)
    if ($request->hasFile('avatar')) {
        // Store file, delete old
    }
    // Handle avatar_base64 (from crop)
    elseif ($request->has('avatar_base64')) {
        if ($request->avatar_base64 === 'remove') {
            // Delete avatar
        }
        elseif (str_starts_with($request->avatar_base64, 'data:image')) {
            // Decode base64, save as PNG
        }
    }
}
```

### Frontend Implementation:

#### Cropper.js Configuration:
```javascript
new Cropper(cropImage, {
    aspectRatio: 1,           // Square crop
    viewMode: 1,              // Restrict to container
    minCropBoxWidth: 200,
    minCropBoxHeight: 200,
    autoCropArea: 1,          // Full area
    responsive: true,
    guides: true,
    center: true,
    cropBoxMovable: true,
    cropBoxResizable: true
});
```

#### Sweet Alert Examples:
```javascript
// Success Toast
Swal.fire({
    icon: 'success',
    title: 'Photo Updated',
    toast: true,
    position: 'top-end',
    timer: 2000,
    showConfirmButton: false
});

// Confirmation
Swal.fire({
    title: 'Remove Profile Picture?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc3545'
});
```

### Bootstrap 5 Components:
- Cards (`card`, `card-body`, `card-title`)
- Grid system (`row`, `col-md-*`)
- Forms (`form-control`, `form-select`, `input-group`)
- Buttons (`btn`, `btn-primary`, `btn-outline-*`)
- Modals (Bootstrap Modal API)
- Badges (`badge`, `bg-primary`)
- Alerts (`alert`, `alert-danger`)

### Lucide Icons:
```html
<i data-lucide="camera"></i>
<i data-lucide="edit-3"></i>
<i data-lucide="save"></i>
<i data-lucide="trash-2"></i>
<i data-lucide="instagram"></i>
<i data-lucide="linkedin"></i>
<i data-lucide="globe"></i>
```

## 🔄 Routing Changes

### Before:
```php
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
```

### After:
```php
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
```

## 📱 Responsive Design

### Breakpoints:
- **Mobile** (< 768px): 1 column stack
- **Tablet** (768px - 992px): Adaptive layout
- **Desktop** (> 992px): 2-3 column layout

### Mobile Optimizations:
- Stacked cards
- Full-width inputs
- Touch-friendly buttons
- Optimized crop modal

## 🎯 Features Checklist

### View Profile:
- [x] Read-only display
- [x] Professional layout
- [x] Avatar dengan status online
- [x] Social media links
- [x] Role badges
- [x] Quick info sidebar
- [x] Edit button
- [x] Delete account option

### Edit Profile:
- [x] Noble UI template
- [x] Avatar upload dengan crop
- [x] Preview sebelum save
- [x] Remove avatar option
- [x] All profile fields
- [x] Social links dengan icon
- [x] Sweet Alert notifications
- [x] Validation feedback
- [x] Change password section
- [x] Delete account section

### Edit Member (Admin):
- [x] Noble UI template
- [x] Same crop feature
- [x] Membership role dropdown
- [x] Division dropdown
- [x] Active status toggle
- [x] Sweet Alert notifications
- [x] All member fields

## 🔒 Security & Validation

### Validation Rules:
- Name: required, string, max:255
- Email: required, email, unique
- Username: nullable, string, unique
- Phone: nullable, string, max:20
- Student Number: nullable, string, max:50
- Batch Year: integer, 2000-{currentYear+5}
- Gender: in:male,female
- Birth Date: date, before:tomorrow
- Avatar: image, max:2MB (2048KB)
- URLs: url format validation

### Security:
- CSRF protection
- File type validation (MIME)
- File size validation
- Old avatar cleanup
- Base64 sanitization
- Unique email/username check

## 📊 Performance

### Optimizations:
- Lazy load Cropper.js
- Destroy cropper after use
- Efficient base64 encoding
- Optimized image output (400x400)
- CDN untuk libraries
- Minimal DOM manipulation

### Libraries Loading:
- Cropper.js: Only on edit pages
- Sweet Alert 2: Only when needed
- Bootstrap JS: Base template
- Lucide Icons: Auto-initialize

## 🎨 UI/UX Improvements

### Before (Breeze):
- Tailwind CSS styling
- Simple forms
- No image crop
- Basic notifications
- Separate pages with different styles

### After (Noble UI):
- Bootstrap 5 styling
- Professional cards
- Advanced crop feature
- Sweet Alert notifications
- Consistent design dengan admin

### User Experience:
- ✅ Clear separation (View vs Edit)
- ✅ Visual feedback (hover, focus)
- ✅ Progress indication
- ✅ Error highlighting
- ✅ Toast notifications
- ✅ Responsive modal
- ✅ Intuitive buttons

## 🚀 Usage Guide

### View Profile:
1. Login ke aplikasi
2. Navigate ke **`/profile`**
3. Lihat informasi profile lengkap
4. Click **"Edit Profile"** untuk edit

### Edit Profile:
1. Dari view profile, click **"Edit Profile"**
2. Update informasi yang diperlukan
3. **Upload Avatar**:
   - Click avatar atau camera button
   - Select image
   - Crop di modal
   - Click "Apply"
4. **Remove Avatar**:
   - Click "Remove Photo"
   - Confirm di Sweet Alert
5. Click **"Save Changes"**
6. Sweet Alert konfirmasi muncul

### Edit Member (Admin):
1. Login sebagai admin
2. Navigate ke **Admin → Members**
3. Click edit icon pada member
4. Update informasi (termasuk role & division)
5. Upload/crop avatar (sama seperti profile)
6. Toggle status aktif
7. Click **"Simpan Perubahan"**

## 🆘 Troubleshooting

### Cropper tidak muncul:
- Check browser console
- Verify Cropper.js CDN loaded
- Ensure modal Bootstrap initialized

### Upload gagal:
- Check file size < 2MB
- Verify file format (JPG/PNG/GIF)
- Check storage permissions
- Run: `php artisan storage:link`

### Sweet Alert tidak muncul:
- Verify Sweet Alert CDN
- Check browser console
- Ensure no JavaScript errors

### Icons tidak muncul:
- Verify Lucide CDN
- Call `lucide.createIcons()` after DOM change
- Check icon names

## 📞 Summary

### Key Changes:
1. ✅ **Separated** View & Edit Profile
2. ✅ **Migrated** ke Noble UI (Bootstrap 5)
3. ✅ **Added** Image Crop feature (Cropper.js)
4. ✅ **Integrated** Sweet Alert 2
5. ✅ **Updated** Edit Member dengan fitur yang sama
6. ✅ **Consistent** design dengan admin template
7. ✅ **Enhanced** UX dengan better notifications
8. ✅ **Responsive** mobile-friendly design

### Routes:
- `GET /profile` → View Profile (read-only)
- `GET /profile/edit` → Edit Profile
- `PATCH /profile` → Update Profile
- `GET /admin/members/{id}/edit` → Edit Member

Semua fitur sudah terintegrasi dengan baik, konsisten dengan Noble UI template, dan ready to use! 🎉
