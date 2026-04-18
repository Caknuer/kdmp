<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemberRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Member $member,
        public string $password,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->member->email,
            subject: 'Selamat Datang! Akun Anda Telah Terdaftar - KDMP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.member_registration',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
