<?php

namespace App\Livewire\Messages\Sellers;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\InternalMessage;
use App\Models\Product;
use Livewire\Attributes\Layout;
use App\Services\UserMessagesService;
/* #[Layout('layouts.guest')] */

class MessagesTable extends Component
{
    use WithPagination;
    //public $messages;
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
    public $selected_side = 'in';
    public $modal_title = null;

    public $this_subject = null;
    public $this_body = null;
    public $this_sender_name = null;
    public $this_msg_id;
    public $this_original_body = null;
    public $modalstatus = null;
    public $this_msg = null;
    public $item_sender_id = null;
    public $product_id = null;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }


    public function viewmessage($message_id)
    {
        $this->message = InternalMessage::find($message_id);
        $this->message_id = $message_id;
        $this->sent_to_id = $this->message->sent_to_id;
        $this->sender_id = $this->message->sender_id;
        $this->subject = $this->message->subject;
        $this->modal_title = $this->message->subject;
        $this->this_original_body = $this->message->body;
        $this->this_sender_name = $this->message->sender_name;
        $this->recepient_name = $this->message->recepient_name;
        $this->original_recepient_name = $this->message->original_recepient_name;
        $this->original_recepient_id = $this->message->original_recepient_id;
        $this->recepient_message_id = $this->message->id;
        $this->modalstatus      = 'view';
        $this->dispatch('open-admin-modal');
    }

    #[On('open-compose-edit')]
    public function compose($message_id, $sender_id)
    {
        $this->item_sender_id = $sender_id;
        $this->this_msg = InternalMessage::find($message_id);
        $this->this_subject = $this->this_msg->subject;
        $this->this_body = null;
        $this->this_sender_name = $this->this_msg->sender_name;
        $this->this_msg_id = $this->this_msg->id;
        $this->modal_title      = $this->this_subject;
        $this->this_original_body      = $this->this_msg->body;
        $this->modalstatus      = 'send';
        UserMessagesService::markAsSeen($message_id);
        $this->dispatch('open-admin-modal');
    }

    public function composenew($product_id = 1, $sender_id)
    {
        // dd($message_id);
        $this->product_id = $product_id;
        $product = Product::find($product_id);
        $this->this_subject = 'Új üzenet: ' . $product->name;
        $this->sent_to_id = $product->user_id;
        $this->item_sender_id = $sender_id;
        $this->modalstatus      = 'new';

        $this->dispatch('open-admin-modal');
    }

    #[On('submit')]
    public function submit()
    {
        if ($this->this_body == null) return;
        if ($this->modalstatus == 'send') {
            UserMessagesService::answerMessage($this->this_msg_id, $this->user_id, $this->item_sender_id, $this->this_body);
        } elseif ($this->modalstatus == 'new') {
            UserMessagesService::sendMessage($this->user_id, $this->sent_to_id, $this->this_body, $this->product_id, $this->this_subject);
        }
        $this->cancelSubmit();
    }

    #[On('cancelSubmit')]
    public function cancelSubmit()
    {
        $this->this_subject = null;
        $this->this_body = null;
        $this->body = null;
        $this->this_sender_name = null;
        $this->this_msg_id = null;
        $this->modal_title      = null;
        $this->modalstatus = null;
        $this->this_original_body = null;
        $this->item_sender_id = null;
        $this->product_id = null;

        $this->dispatch('close-modal');
    }

    #[On('updateBody')]
    public function updateBody($body)
    {
        $this->this_body = $body;
    }

    public function setselected_msg($value)
    {
        dd($value);
    }

    public function changeSelectedSide($value)
    {
        $this->selected_side = $value;
    }


    public function render()
    {
        return view('livewire.messages.sellers.messages-table', [
            'messages' => InternalMessage::where('sent_to_id', $this->user_id)->where('archived_by_receiver', false)->orderBy('created_at', 'desc')->paginate(20),
            'count_notseen_messages' => InternalMessage::where('sent_to_id', $this->user_id)->where('seen', false)->where('archived_by_receiver', false)->count(),
            'outmessages' => InternalMessage::where('sender_id', $this->user_id)->where('archived_by_sender', false)->orderBy('created_at', 'desc')->paginate(20),
        ]);
    }
}
