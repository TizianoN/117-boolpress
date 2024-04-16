<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreatedPostMail extends Mailable
{
  use Queueable, SerializesModels;

  public $post;
  public $user;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($_post, $_user)
  {
    $this->post = $_post;
    $this->user = $_user;
  }

  /**
   * Get the message envelope.
   *
   * @return \Illuminate\Mail\Mailables\Envelope
   */
  public function envelope()
  {
    return new Envelope(
      subject: 'Created Post Mail'
    );
  }

  /**
   * Get the message content definition.
   *
   * @return \Illuminate\Mail\Mailables\Content
   */
  public function content()
  {
    $user = $this->user;
    $post = $this->post;

    return new Content(
      markdown: 'emails.posts.created-post',
      with: compact('user', 'post')
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array
   */
  public function attachments()
  {
    return [];
  }
}
