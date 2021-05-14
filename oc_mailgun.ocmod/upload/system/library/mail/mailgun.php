<?php

namespace Mail;

const MAILGUN_URL = getenv('MAILGUN_URL');
const MAILGUN_KEY = getenv('MAILGUN_KEY');

class Mailgun {
	
	public function send()
	{
		if (is_array($this->to)) {
			$to = implode(',', $this->to);
		} else {
			$to = $this->to;
		}

		$post_data = [
			'from' => $this->sender .'<'.$this->from.'>',
			'to' => $this->to,
			'subject' => $this->subject,
			'text' => $this->text,
			'html' => $this->html
		];

		$session = curl_init(MAILGUN_URL.'/messages');
		curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($session, CURLOPT_USERPWD, 'api:'.MAILGUN_KEY);
		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);

		curl_exec($session);
		curl_close($session);
	}
	
}
