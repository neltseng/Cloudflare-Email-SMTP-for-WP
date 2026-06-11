# Cloudflare Email SMTP for WordPress

A tiny, dependency-free snippet that routes **all** WordPress mail (`wp_mail()`)
through **Cloudflare Email Service**'s SMTP relay. No plugin, no settings page,
no secret stored in code — the API token lives only in `wp-config.php`.

## Requirements

- Cloudflare **Email Sending** enabled, with your sending domain **onboarded/verified**.
  Sending to arbitrary recipients requires the **Workers Paid** plan.
- A Cloudflare API token with the **`Email Sending: Edit`** permission
  (Dashboard → Email → Connect to Email Service → SMTP → *Create token*).
- WordPress with outbound TCP **port 465** open (implicit TLS / SMTPS).
  Port 587 / STARTTLS is **not** supported.

## Install

1. Paste the whole snippet from `cf-smtp-mailer.php` into your active theme's
   `functions.php`.
2. Add your token to `wp-config.php` (above `/* That's all, stop editing! */`).
   **Never commit this line to git:**
   ```php
   define( 'CF_SMTP_TOKEN', 'your-cloudflare-api-token' );
   ```
3. In the snippet, change `noreply@example.com` to an address on your
   **verified sending domain**. Cloudflare rejects any `From` outside a
   verified domain.

## How it works

- `phpmailer_init` points WordPress's built-in PHPMailer at
  `smtp.mx.cloudflare.net:465` and authenticates with username `api_token`
  and your token as the password.
- `wp_mail_from` forces the `From` address to your verified domain so
  Cloudflare accepts the message; `wp_mail_from_name` defaults to your site name.

## Security

The token is read from the `CF_SMTP_TOKEN` constant in `wp-config.php`, so the
code contains **no secrets** and is safe to share or commit. Keep the token out
of the theme, the repo, and any synced/backed-up location.

## License

GPL-2.0-or-later

---

# Cloudflare Email SMTP for WordPress（中文）

一段極簡、零依賴的程式碼，把 WordPress 的所有寄信（`wp_mail()`）導向
**Cloudflare Email Service** 的 SMTP relay。不是外掛、沒有設定頁、程式碼裡不存任何密鑰
——API token 只放在 `wp-config.php`。

## 前置需求

- Cloudflare 已啟用 **Email Sending**，且寄件網域已 **onboard/驗證**。
  寄給任意收件人需 **Workers Paid** 方案。
- 一組權限為 **`Email Sending: Edit`** 的 Cloudflare API token
  （後台 → Email → Connect to Email Service → SMTP → 建立 token）。
- 主機對外 **465 埠**（implicit TLS / SMTPS）需可連；**不支援** 587 / STARTTLS。

## 安裝

1. 把 `cf-smtp-mailer.php` 的整段程式碼貼進目前主題的 `functions.php`。
2. 在 `wp-config.php` 加入 token（放在 `/* That's all, stop editing! */` 之前）。
   **這行絕對不要提交進 git：**
   ```php
   define( 'CF_SMTP_TOKEN', 'your-cloudflare-api-token' );
   ```
3. 把貼上的程式碼裡的 `noreply@example.com` 改成你**已驗證寄件網域**下的信箱。
   Cloudflare 會拒收 `From` 不在驗證網域內的信。

## 運作方式

- `phpmailer_init`：讓 WordPress 內建的 PHPMailer 連到
  `smtp.mx.cloudflare.net:465`，帳號用 `api_token`、密碼用你的 token。
- `wp_mail_from`：強制 `From` 為你的驗證網域，Cloudflare 才會收；
  `wp_mail_from_name` 預設用站台名稱。

## 安全性

token 由 `wp-config.php` 的 `CF_SMTP_TOKEN` 常數讀入，所以這段程式碼**不含任何密鑰**，
可安全分享或提交。token 請勿放進主題、repo 或任何會同步／備份的位置。

## 授權

GPL-2.0-or-later
