# Two-Factor Authentication (2FA) / OTP Tutorial

A simple PHP-based implementation of Two-Factor Authentication (2FA) using Time-based One-Time Passwords (TOTP) with QR code generation.

## 📋 Overview

This project demonstrates how to implement 2FA authentication in PHP by:
1. Generating a unique secret key based on the user's email
2. Creating a QR code that can be scanned by authenticator apps
3. Verifying the OTP code entered by the user

## 🚀 Features

- **TOTP Implementation**: Uses SHA256 algorithm with 6-digit codes
- **QR Code Generation**: Automatically generates QR codes for easy setup
- **Session-based Storage**: Stores OTP secrets in PHP sessions
- **Email-based User Identification**: Uses email as the user identifier

## 📁 Project Structure

```
2fa-otp/
├── form.html      # Initial form to enter email
├── form.php       # Main PHP logic for 2FA setup and verification
├── qrcode.png     # Generated QR code image
└── README.md      # This file
```

## 🛠️ Prerequisites

### System Requirements

- PHP 8.x
- Web server (Apache, Nginx, etc.)
- `qrencode` command-line utility for QR code generation
- `oathtool` for OTP verification

### Install Dependencies

#### Ubuntu/Debian
```bash
sudo apt-get update
sudo apt-get install qrencode oathtool
```

#### CentOS/RHEL
```bash
sudo yum install qrencode oathtool
```

#### macOS
```bash
brew install qrencode oathtool
```

## 📖 How It Works

### Step 1: User Registration
1. User enters their email address in `form.html`
2. The email is submitted to `form.php`

### Step 2: Secret Key Generation
1. A unique secret key is generated from the email using Base32 encoding
2. The secret is stored in the PHP session

### Step 3: QR Code Creation
1. An `otpauth://` URI is constructed with:
   - **Issuer**: OjamboShow
   - **Account**: User's email
   - **Secret**: Generated Base32 secret
   - **Algorithm**: SHA256
   - **Digits**: 6
   - **Period**: 30 seconds
2. The QR code is generated using `qrencode` and saved as `qrcode.png`

### Step 4: User Scans QR Code
1. User scans the QR code with their authenticator app (Google Authenticator, Authy, etc.)
2. The app stores the secret and generates time-based codes

### Step 5: OTP Verification
1. User enters the 6-digit code from their authenticator app
2. The server generates the expected code using `oathtool`
3. If the codes match, authentication is successful

## 🏃‍♂️ Usage

1. **Place the files** in your web server's document root
2. **Open `form.html`** in your browser
3. **Enter your email** and submit
4. **Scan the QR code** with your authenticator app
5. **Enter the OTP code** from your app to verify

## ⚠️ Security Considerations

> **⚠️ WARNING**: This is a tutorial/demo implementation. Do NOT use in production without addressing the following security concerns:

### Current Limitations

1. **No Input Sanitization**: Email and OTP inputs need proper validation and sanitization
2. **Weak Secret Generation**: The current Base32 encoding of email is not cryptographically secure
3. **Session Security**: Consider using secure, HTTP-only cookies
4. **Rate Limiting**: No protection against brute-force attacks
5. **Secret Storage**: Secrets are stored in sessions; consider a database with encryption
6. **HTTPS Required**: Always use HTTPS in production to protect secrets in transit

### Recommended Improvements

```php
// TODO: Replace with cryptographically secure secret generation
$secret = bin2hex(random_bytes(20));

// TODO: Add input validation and sanitization
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

// TODO: Implement rate limiting
// TODO: Use prepared statements if storing in database
// TODO: Add CSRF protection
// TODO: Implement proper error handling
```

## 🔧 Configuration

You can customize the TOTP parameters in `form.php`:

```php
$otpauth = "otpauth://totp/OjamboShow:{$name}?secret={$secret}&issuer=OjamboShow&algorithm=SHA256&digits=6&period=30";
```

| Parameter | Description | Default |
|-----------|-------------|---------|
| `algorithm` | Hash algorithm | SHA256 |
| `digits` | Number of digits in OTP | 6 |
| `period` | Time period in seconds | 30 |
| `issuer` | Application name | OjamboShow |

## 📚 Supported Authenticator Apps

- Google Authenticator
- Microsoft Authenticator
- Authy
- 1Password
- LastPass
- And any app that supports the `otpauth://` URI scheme

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 👤 Author

Based on the OjamboShow tutorial implementation.

## 📞 Support

For issues and feature requests, please open an issue on GitHub.

---

**Note**: This is an educational project. For production use, consider established libraries like [PHPGangsta/GoogleAuthenticator](https://github.com/PHPGangsta/GoogleAuthenticator) or [spomky-labs/otphp](https://github.com/Spomky-Labs/otphp).
