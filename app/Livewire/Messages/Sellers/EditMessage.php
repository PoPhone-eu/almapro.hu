<?php

namespace App\Livewire\Messages\Sellers;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use App\Models\InternalMessage;
use Livewire\Attributes\Layout;
use App\Services\UserMessagesService;

class EditMessage extends Component
{
    public $user_id;
    public $message_id;
    public $message;
    public $sent_to_id;
    public $sender_id;
    public $subject;
    public $body;
    public $sender_name;
    public $recepient_name;
    public $original_recepient_name;
    public $original_recepient_id;
    public $recepient_message_id;
    public $messageService;
    public $selected_msg = null;

    public $this_subject = null;
    #[Rule('required')]
    public $this_body = null;
    public $this_sender_name = null;
    public $this_msg_id;
    public $this_original_body = null;
    public $modalstatus = null;
    public $this_msg = null;
    public $item_sender_id = null;
    public $product_id = null;

    public function mount($message_id)
    {
        $this->message_id = $message_id;
        $this->message = InternalMessage::find($message_id);
        $this->product_id = $this->message->product_id;
        $this->user_id = auth()->user()->id;
        $this->message_id = $message_id;
        $this->sent_to_id = $this->message->sent_to_id;
        $this->sender_id = $this->message->sender_id;
        $this->subject = $this->message->subject;
        $this->this_original_body = $this->message->body;
        $this->this_sender_name = $this->message->sender_name;
        $this->recepient_name = $this->message->recepient_name;
        $this->original_recepient_name = $this->message->original_recepient_name;
        $this->original_recepient_id = $this->message->original_recepient_id;
        $this->recepient_message_id = $this->message->id;
        $this->item_sender_id = $this->message->senderid;
        $this->message->seen = true;
        $this->message->save();
        $this->dispatch('reloadit');
    }

    public function submit()
    {
        $this->validate([
            'this_body' => 'required',
        ]);
        if ($this->this_body == null) return;
        UserMessagesService::answerMessage($this->message_id, $this->user_id, $this->item_sender_id, $this->this_body);
        //sleep(0.5);
        $this->redirect('/messages', navigate: true);
    }

    #[On('updateBody')]
    public function updateBody($body)
    {
        // reset error bag
        $this->resetErrorBag();
        $this->this_body = $body;
    }

    public function render()
    {
        // dd($this->message);
        return view('livewire.messages.sellers.edit-message');
    }
}
