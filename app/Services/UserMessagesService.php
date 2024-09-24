<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\UserInfo;
use App\Models\CustomerOrder;
use App\Models\InternalMessage;

class UserMessagesService
{

    // getter for all messages
    public static function  getAllMessages($user_id)
    {
        return InternalMessage::where('sent_to_id', $user_id)->orWhere('sender_id', $user_id)->orderBy('created_at', 'desc')->get();
    }

    // getter for incoming messages
    public static function  getIncomingMessages($user_id)
    {
        return InternalMessage::where('sent_to_id', $user_id)->where('archived_by_receiver', false)->orderBy('created_at', 'desc')->get();
    }

    // getter for outgoing messages
    public static function  getOutgoingMessages($user_id)
    {
        return InternalMessage::where('sender_id', $user_id)->where('archived_by_sender', false)->orderBy('created_at', 'desc')->get();
    }

    // get all messages sent by another user
    public static function  getMessagesSentByUser($user_id)
    {
        return InternalMessage::where('sender_id', $user_id)->where('sent_to_id', $user_id)->orderBy('created_at', 'desc')->get();
    }

    // get all messages sent to another user:
    public static function  getMessagesSentToUser($user_id)
    {
        return InternalMessage::where('sender_id', $user_id)->where('sent_to_id', $user_id)->orderBy('created_at', 'desc')->get();
    }

    // get a message by id
    public static function  getMessageById($message_id)
    {
        return InternalMessage::find($message_id);
    }

    // query messages by recepient_name column search
    public static function  queryMessagesByRecepientName($user_id, $query)
    {
        return InternalMessage::where('recepient_name', 'LIKE', '%' . $query . '%')->where('archived_by_receiver', false)->where('sender_id', $user_id)->orderBy('created_at', 'desc')->get();
    }

    // query messages by subject column where sender_id is the current user or sent_to_id is the current user
    public static function  queryMessagesBySubject($user_id, $query)
    {
        return InternalMessage::where('subject', 'LIKE', '%' . $query . '%')->where('sender_id', $user_id)->where('archived_by_receiver', false)->orderBy('created_at', 'desc')->get();
    }

    // get messages groupd by original_recepient_id column. This is used to display the messages in the inbox
    public static function  getMessagesGroupedByOwnerId($user_id)
    {
        return InternalMessage::where('sender_id', $user_id)->orWhere('sent_to_id', $user_id)->orderBy('created_at', 'desc')->get()->groupBy('owner_id');
    }

    // get messages groupd by subject column. This is used to display the messages in the inbox
    public static function  getMessagesGroupedBySubject($user_id)
    {
        return InternalMessage::where('sender_id', $user_id)->orWhere('sent_to_id', $user_id)->orderBy('created_at', 'desc')->get()->groupBy('subject');
    }

    // save new message sent by the current user
    public static function sendMessage($user_id, $sent_to_id, $body, $product_id = null, $this_subject)
    {
        $product = null;
        if ($product_id != null) $product = Product::find($product_id);

        $user = User::find($user_id);
        $recepient = User::find($sent_to_id);
        $message = new InternalMessage();
        if ($product != null) {
            $message->product_id = $product->id;
            $message->product_name = $product->name;
        }
        $message->sender_name = $user->full_name;
        $message->senderid = $user_id;
        $message->sender_id = $user_id;
        $message->owner_id = $user_id;
        $message->body = $body;
        $message->recepient_name = $recepient->full_name;
        $message->original_recepient_name = $recepient->full_name;
        $message->original_recepient_id = $recepient->id;
        $message->seen = false;
        $message->subject = $this_subject;
        $message->draft = false;
        $message->urgent = false;
        $message->starred = false;
        $message->copies = false;
        $message->archived_by_sender = false;
        $message->archived_by_receiver = false;
        $message->sent_to_id = $sent_to_id;
        $message->save();
        if ($recepient->email != null) UserMessagesService::sendMail($recepient->email);
    }

    // save new order message sent by the current customer
    public static function sendOrderMessage($customer_id, $seller_id, $body, $product_id, $this_subject)
    {
        $customer = User::find($customer_id);
        $seller = User::find($seller_id);
        $sellerInfo = UserInfo::where('user_id', $seller_id)->first();
        $product = Product::find($product_id);
        $newOrder = new CustomerOrder();
        $newOrder->product_id = $product->id;
        $newOrder->product_name = $product->name;
        $newOrder->customer_id = $customer_id;
        $newOrder->customer_name = $customer->full_name;
        $newOrder->customer_email = $customer->email;
        $newOrder->customer_phone = $customer->phone;
        $newOrder->seller_id = $seller_id;
        $newOrder->seller_name = $sellerInfo->company_name;
        $newOrder->order_status = 'new';
        $newOrder->save();


        if ($customer->email != null) UserMessagesService::sendOrderMailToCustomer($customer->email, $newOrder);
        if ($seller->email != null) UserMessagesService::sendOrderMailToSeller($seller->email, $newOrder);
    }

    public static function sendOrderMailToCustomer($email, $order)
    {
        // we dont have it yet. Later...
    }

    public static function sendOrderMailToSeller($email, $order)
    {
        // we dont have it yet. Later...
    }

    // answer a message sent by other user
    public static function answerMessage($message_id, $user_id, $sent_to_id, $body)
    {
        $original_message = InternalMessage::find($message_id);
        $subject = 'Re: ' . $original_message->subject;
        $user = User::find($user_id);
        $this_body = $body . '<br><br>Előzmény:<br>' . $original_message->body;
        $recepient = User::find($sent_to_id);
        $message = new InternalMessage();
        $message->sender_name = $user->full_name;
        $message->product_id = $original_message->product_id;
        $message->product_name = $original_message->product_name;
        $message->senderid = $user_id;
        $message->sender_id = $user_id;
        $message->owner_id = $original_message->owner_id;
        $message->body = $this_body;
        $message->recepient_name = $recepient->full_name;
        $message->original_recepient_name = $original_message->original_recepient_name;
        $message->original_recepient_id = $original_message->original_recepient_id;
        $message->seen = false;
        $message->subject = $subject;
        $message->draft = false;
        $message->urgent = false;
        $message->starred = false;
        $message->copies = false;
        $message->archived_by_sender = false;
        $message->archived_by_receiver = false;
        $message->sent_to_id = $sent_to_id;
        $message->save();
        if ($recepient->email != null) UserMessagesService::sendMail($recepient->email);
    }

    public static function markAsSeen($message_id)
    {
        $message = InternalMessage::find($message_id);
        $message->seen = true;
        $message->update();
    }

    public static function markAsStarred($message_id)
    {
        $message = InternalMessage::find($message_id);
        $message->starred = true;
        $message->update();
    }

    public static function markAsUnstarred($message_id)
    {
        $message = InternalMessage::find($message_id);
        $message->starred = false;
        $message->update();
    }

    public static function markAsUrgent($message_id)
    {
        $message = InternalMessage::find($message_id);
        $message->urgent = true;
        $message->update();
    }

    public static function markAsUnurgent($message_id)
    {
        $message = InternalMessage::find($message_id);
        $message->urgent = false;
        $message->update();
    }

    public static function markAsDraft($message_id)
    {
        $message = InternalMessage::find($message_id);
        $message->draft = true;
        $message->update();
    }

    public static function markAsUndraft($message_id)
    {
        $message = InternalMessage::find($message_id);
        $message->draft = false;
        $message->update();
    }

    public static function deleteMessage($message_id)
    {
        $message = InternalMessage::find($message_id);
        $message->delete();
    }

    // send mail function
    public static function sendMail($email)
    {
        // we dont have it yet. Later...
    }
}
