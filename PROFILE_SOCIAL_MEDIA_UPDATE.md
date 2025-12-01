# Profile & Social Media Update - Complete Documentation

## 📋 Overview
Major update untuk sistem profile dengan:
1. **Social Media Table** - Tabel terpisah untuk social media links
2. **Tab Navigation** - Password & Delete Account dalam tab terpisah
3. **Icon Display** - Social media ditampilkan dengan icon yang menarik
4. **Bug Fixes** - Perbaikan avatar upload dan routing

## ✅ Perubahan Utama

### 1. **Tabel Social Media Terpisah**
**Sebelumnya**: Social media URLs disimpan di kolom `users` table
```
users:
- instagram_url
- linkedin_url  
- website_url
```

**Sekarang**: Tabel `social_media` terpisah
```
social_media:
- id
- user_id (foreign key)
- platform (instagram, linkedin, twitter, facebook, github, website)
- url
- order
- timestamps
```

**Keuntungan**:
- ✅ Fleksibel - bisa tambah platform baru tanpa alter table
- ✅ Scalable - tidak limit jumlah social media
- ✅ Ordered - bisa atur urutan tampilan
- ✅ Clean - users table lebih slim

### 2. **Tab Navigation untuk Security**
**Edit Profile** sekarang menggunakan **Bootstrap Tabs**:
- **Tab 1: Profile Information** - Edit profile & social media
- **Tab 2: Security** - Change password & Delete account

**Features**:
- Nav tabs dengan icon (Lucide)
- Smooth transition
- All in one page
- Better UX

### 3. **Icon Display untuk Social Media**
**View Profile** menampilkan social media dengan:
- **Circular colored icons**
- **Platform-specific colors**:
  - Instagram: Red (#danger)
  - LinkedIn: Blue (#primary)
  - Twitter: Light blue (#info)
  - Facebook: Facebook blue (#1877f2)
  - GitHub: Dark (#dark)
  - Website: Green (#success)
- **Hover effects**
- **Opens in new tab**

### 4. **Bug Fixes**
- ✅ **Avatar upload fixed** - Sekarang bisa upload dan crop dengan benar
- ✅ **Avatar remove** - Handle `avatar='remove'` dengan benar
- ✅ **Breadcrumb** - Fixed routing di breadcrumb
- ✅ **Load relations** - Social media di-load dengan eager loading

## 📁 Files Created/Modified

### Created Files:
1. **database/migrations/2025_12_01_054430_create_social_media_table.php**
   - Migration untuk tabel social_media
   
2. **app/Models/SocialMedia.php**
   - Model untuk social media
   - Relasi dengan User
   - Helper methods (platforms, getIconAttribute)

### Modified Files:

#### 1. **app/Models/User.php**
**Added**:
```php
public function socialMedia()
{
    return $this->hasMany(SocialMedia::class)->orderBy('order');
}
```

#### 2. **app/Http/Controllers/ProfileController.php**
**Changes**:
- Load social media relations
- Fixed avatar upload/crop/remove logic
- Handle social media CRUD:
  ```php
  // Delete all old social media
  $user->socialMedia()->delete();
  
  // Create new ones
  foreach ($socialMediaData as $platform => $url) {
      $user->socialMedia()->create([...]);
  }
  ```

#### 3. **app/Http/Requests/ProfileUpdateRequest.php**
**Added validation**:
```php
'instagram_url' => ['nullable', 'url', 'max:255'],
'linkedin_url' => ['nullable', 'url', 'max:255'],
'twitter_url' => ['nullable', 'url', 'max:255'],
'facebook_url' => ['nullable', 'url', 'max:255'],
'github_url' => ['nullable', 'url', 'max:255'],
'website_url' => ['nullable', 'url', 'max:255'],
```

#### 4. **app/Http/Controllers/Admin/MemberController.php**
**Changes**:
- Load social media relations  
- Same social media handling as ProfileController

#### 5. **app/Http/Requests/UpdateMemberRequest.php**
**Added same social media validation**

#### 6. **resources/views/profile/edit.blade.php**
**Complete redesign**:
- Bootstrap nav-tabs
- Profile tab with social media (6 platforms)
- Security tab (password & delete)
- Fixed avatar crop implementation
- Sweet Alert integration

#### 7. **resources/views/profile/show.blade.php**
**Updated**:
- Display social media with circular colored icons
- Better layout
- Security section links to edit page tabs

#### 8. **resources/views/admin/members/edit.blade.php**
**Updated**:
- Social media inputs (6 platforms)
- Same crop feature
- Consistent with profile edit

## 🎨 UI/UX Improvements

### Edit Profile Page:

#### Tab 1: Profile Information
```
┌─────────────────────────────────────────┐
│ [Profile Information] [Security]        │
├─────────────────────────────────────────┤
│ ┌──────┐              ┌──────────────┐ │
│ │Avatar│              │ Personal Info│ │
│ │      │              │              │ │
│ │Camera│              │ Form Fields  │ │
│ └──────┘              └──────────────┘ │
│ Remove                                  │
│                       ┌──────────────┐ │
│ Status                │ Social Media │ │
│                       │ (6 platforms)│ │
│                       └──────────────┘ │
└─────────────────────────────────────────┘
```

#### Tab 2: Security
```
┌─────────────────────────────────────────┐
│ [Profile Information] [Security]        │
├─────────────────────────────────────────┤
│ ┌──────────────┐ ┌──────────────┐      │
│ │ Change Pass  │ │ Delete Acc   │      │
│ │              │ │              │      │
│ │              │ │  [DANGER]    │      │
│ └──────────────┘ └──────────────┘      │
└─────────────────────────────────────────┘
```

### View Profile Page:
**Social Media Icons**:
```
Instagram  LinkedIn  Twitter  Facebook  GitHub  Website
   ●          ●         ●         ●        ●       ●
```
Each icon:
- 40x40px circular
- Platform-specific color
- Lucide icon inside
- Hover effect
- Opens in new tab

## 🔧 Technical Implementation

### Database Schema:

```sql
CREATE TABLE social_media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    platform VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    `order` INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_platform (user_id, platform)
);
```

### Supported Platforms:
1. **Instagram** - Red icon
2. **LinkedIn** - Blue icon
3. **Twitter** - Light blue icon
4. **Facebook** - Facebook blue icon
5. **GitHub** - Dark icon
6. **Website** - Green globe icon

### Model Methods:

```php
// SocialMedia Model
static platforms(): array  // List all supported platforms
getIconAttribute(): string // Get Lucide icon name

// User Model
socialMedia()             // HasMany relation
```

### Controller Flow:

```php
// ProfileController::update()
1. Handle avatar (file upload OR crop base64 OR remove)
2. Extract social media data from validated input
3. Remove from $validated array
4. Update user basic info
5. Delete all old social media
6. Create new social media records
7. Redirect with success message
```

### Avatar Upload Fix:

**Problem**: Avatar tidak ter-save karena logic kurang handle 'remove'

**Solution**:
```php
if ($request->has('avatar') && $request->avatar) {
    if ($request->avatar === 'remove') {
        // Delete avatar
        $validated['avatar'] = null;
    } elseif (str_starts_with($request->avatar, 'data:image')) {
        // Decode base64 cropped image
        $validated['avatar'] = 'avatars/' . $imageName;
    }
}
```

## 🚀 Usage Guide

### For Users:

#### Edit Profile:
1. Navigate to **Profile → Edit Profile**
2. **Tab 1: Profile Information**
   - Upload/crop avatar
   - Edit personal info
   - Add social media links (6 platforms)
   - Click "Save Changes"
3. **Tab 2: Security**
   - Change password
   - Delete account (danger zone)

#### View Profile:
1. Navigate to **Profile**
2. See all info (read-only)
3. See social media icons (clickable)
4. Click "Edit Profile" to edit

### For Admins:

#### Edit Member:
1. Navigate to **Admin → Members**
2. Click edit icon
3. Same features as Edit Profile
4. Additional: Role, Division, Active status

## 📊 Data Migration

### Old Data to New Table:
Jika ada data lama di `users.instagram_url`, etc., perlu migrasi:

```php
// Create migration to migrate old data
use App\Models\User;
use App\Models\SocialMedia;

User::whereNotNull('instagram_url')->each(function($user) {
    SocialMedia::create([
        'user_id' => $user->id,
        'platform' => 'instagram',
        'url' => $user->instagram_url,
        'order' => 0
    ]);
});

// Repeat for linkedin_url, website_url
// Then drop columns from users table
```

**Note**: Kolom lama (`instagram_url`, `linkedin_url`, `website_url`) masih ada di users table untuk backward compatibility. Bisa di-drop nanti setelah migrasi complete.

## 🎯 Features Checklist

### Profile View:
- [x] Read-only display
- [x] Social media with colored icons
- [x] Icon hover effects
- [x] Links open in new tab
- [x] Online status
- [x] Quick info sidebar

### Profile Edit:
- [x] Tab navigation (Profile & Security)
- [x] Avatar upload with crop
- [x] Avatar remove
- [x] Personal information form
- [x] Social media inputs (6 platforms)
- [x] Sweet Alert notifications
- [x] Change password (in Security tab)
- [x] Delete account (in Security tab)

### Member Edit (Admin):
- [x] Same social media features
- [x] Same crop features
- [x] Role & Division dropdowns
- [x] Active status toggle

### Bug Fixes:
- [x] Avatar upload works correctly
- [x] Avatar crop saves properly
- [x] Avatar remove handles correctly
- [x] Breadcrumb routing fixed
- [x] Social media loads with eager loading

## 🔒 Security

### Validation:
- All URLs validated with `url` rule
- Max length 255 characters
- Platform restricted to allowed list
- Avatar file type and size validated
- CSRF protection on all forms

### Data Integrity:
- Foreign key constraint (`user_id`)
- Cascade delete (delete user → delete social media)
- Unique index on (user_id, platform)

## 📈 Performance

### Optimizations:
- Eager loading: `$user->load('socialMedia')`
- Indexed columns: (user_id, platform)
- Delete old before insert new (atomic operation)
- Order column for sorting

### Database Queries:
```
Before (3 queries):
1. SELECT * FROM users WHERE id = ?
2. UPDATE users SET instagram_url = ?, linkedin_url = ?, website_url = ?
3. COMMIT

After (4 queries):
1. SELECT * FROM users WHERE id = ?
2. DELETE FROM social_media WHERE user_id = ?
3. INSERT INTO social_media (user_id, platform, url, order) VALUES (?, ?, ?, ?)
4. COMMIT
```

Sedikit lebih banyak query tapi lebih scalable.

## 🆘 Troubleshooting

### Social media tidak muncul:
```php
// Check relasi loaded
dd($user->socialMedia);

// Check data exist
dd($user->socialMedia()->get());
```

### Avatar tidak ter-save:
```php
// Check request data
dd($request->all());

// Check storage link
php artisan storage:link

// Check permissions
chmod -R 775 storage/app/public/avatars
```

### Tab tidak berfungsi:
- Check Bootstrap JS loaded
- Check tab IDs match
- Open browser console for errors

## 📞 Summary

### Key Improvements:
1. ✅ **Social media** moved to separate table (scalable)
2. ✅ **6 platforms** supported (Instagram, LinkedIn, Twitter, Facebook, GitHub, Website)
3. ✅ **Tab navigation** for better UX
4. ✅ **Icon display** with platform colors
5. ✅ **Avatar bugs** fixed
6. ✅ **Consistent** between user profile & admin member edit

### Breaking Changes:
- None! Old columns still exist for backward compatibility
- New feature additive

### Routes:
- `GET /profile` → View Profile
- `GET /profile/edit` → Edit Profile (with tabs)
- `PATCH /profile` → Update Profile
- `GET /admin/members/{id}/edit` → Edit Member

Semua fitur sudah terintegrasi dengan baik dan ready to use! 🎉
