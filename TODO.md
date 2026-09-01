# TODO Perbaikan Project KDMP

## Kritis
- [x] 1. Fix `app/Models/AboutPage.php` — `Class` → `class`
- [x] 2. Fix `app/Models/Member.php` — extends `Authenticatable` bukan `Model`
- [x] 3. Fix `app/Filament/Widgets/StatsOverview.php` — query type `credit`/`debit`
- [x] 4. Fix `app/Filament/Widgets/FinanceSummary.php` — query type `credit`/`debit`

## Keamanan
- [x] 5. Fix `app/Http/Controllers/PublicMemberController.php` — hapus flash password plaintext
- [x] 6. Fix `app/Providers/AppServiceProvider.php` — pengecekan environment untuk HTTPS
- [x] 7. Fix `app/Models/User.php` — cek `role === 'admin'` di `canAccessPanel()`
- [x] 8. Fix `app/Filament/Pages/FullSetting.php` — jangan `cache()->flush()` semua
- [x] 9. Fix `app/Http/Controllers/Admin/AdminAuthController.php` — ganti `env()` dengan `config()`

## Bug Logika
- [x] 10. Fix `app/Models/OrganizationMember.php` — `$this->photo` → `$this->photo_p`
- [x] 11. Fix `app/Http/Controllers/Admin/AdminMemberController.php` — filter `status`, generate field wajib
- [x] 12. Fix `app/Http/Controllers/Admin/AdminArticleController.php` — set `published_at`
- [x] 13. Fix `app/Http/Controllers/Admin/AdminTransactionController.php` — gunakan filter `$month`
- [x] 14. Fix `app/Http/Controllers/PublicController.php` — kirim `$setting` ke view tentang

## Minor / Kerapihan
- [x] 15. Fix `routes/web.php` — hapus unused import
- [x] 16. Fix `app/Models/User.php` — hapus unused `HasFactory`
- [x] 17. Fix `app/Filament/Resources/Partners/PartnerResource.php` — hapus unused imports + method

