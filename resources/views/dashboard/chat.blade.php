@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">لوحة التحكم - الدردشة</h2>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>اسم المستخدم</th>
                        <th>عدد الرسائل</th>
                        <th>عدد الرسائل غير المردود عليها</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->total_messages }}</td>
                            <td>{{ $user->unreplied_messages }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userChatModal"
                                    onclick="loadUserMessages({{ $user->id }}, '{{ $user->name }}')">
                                    عرض الرسائل
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for User Messages -->
    <div class="modal fade" id="userChatModal" tabindex="-1" aria-labelledby="userChatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="userChatModalLabel">رسائل المستخدم</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="userMessages" class="p-3 border rounded" style="height: 300px; overflow-y: auto;">
                        <!-- سيتم تحميل الرسائل هنا -->
                    </div>
                    <form id="replyForm" class="d-flex mt-3">
                        @csrf
                        <input type="hidden" id="replyToMessageId" name="reply_to">
                        <input type="text" id="replyInput" name="message" placeholder="اكتب ردك..."
                            class="form-control me-2">
                        <button type="submit" class="btn btn-primary">إرسال</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userMessages = document.getElementById('userMessages');
            const replyForm = document.getElementById('replyForm');
            const replyToMessageId = document.getElementById('replyToMessageId');
            const replyInput = document.getElementById('replyInput');
            const userChatModalLabel = document.getElementById('userChatModalLabel');

            // تحميل رسائل المستخدم
            async function loadUserMessages(userId, userName) {
                try {
                    // تحديث عنوان المودال
                    userChatModalLabel.textContent = `رسائل المستخدم: ${userName}`;

                    const response = await fetch(`/dashboard/users/${userId}/messages`);
                    if (response.ok) {
                        const messages = await response.json();
                        userMessages.innerHTML = ''; // تفريغ الرسائل القديمة

                        messages.forEach(message => {
                            const alignment = message.sender_type === 'support' ? 'text-start' :
                                'text-end';
                            const bgColor = message.sender_type === 'support' ?
                                'bg-primary text-white' : 'bg-light';

                            const userName = message.user ? message.user.name : 'مستخدم غير معروف';

                            userMessages.innerHTML += `
                                <div class="${alignment} mb-3">
                                    <div class="d-inline-block p-2 rounded ${bgColor}" style="max-width: 70%;">
                                        <strong>${message.sender_type === 'support' ? 'الدعم' : userName}:</strong>
                                        <span>${message.message}</span>
                                        <div class="small text-muted mt-1">${moment(message.created_at).locale('ar').fromNow()}</div>
                                        ${message.sender_type === 'user' ? `<button class="btn btn-sm btn-link text-primary" onclick="setReplyTo(${message.id})">رد</button>` : ''}
                                    </div>
                                </div>`;
                        });

                        userMessages.scrollTop = userMessages.scrollHeight;
                    } else {
                        console.error('Failed to fetch messages:', response.statusText);
                        alert('فشل في جلب الرسائل، حاول مرة أخرى.');
                    }
                } catch (error) {
                    console.error('Error loading user messages:', error);
                    alert('حدث خطأ أثناء تحميل الرسائل.');
                }
            }

            // تعيين الرد على رسالة معينة
            window.setReplyTo = function(messageId) {
                replyToMessageId.value = messageId;
                replyInput.focus();
            };

            // إرسال الرد
            replyForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = replyInput.value;

                if (!message.trim()) {
                    alert('يرجى كتابة الرد قبل الإرسال.');
                    return;
                }

                try {
                    const response = await fetch(`/dashboard/messages/reply`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            reply_to: replyToMessageId.value,
                            message: message,
                        }),
                    });

                    if (response.ok) {
                        const newMessage = await response.json();
                        userMessages.innerHTML += `
                            <div class="text-start mb-3">
                                <div class="d-inline-block p-2 rounded bg-primary text-white" style="max-width: 70%;">
                                    <strong>الدعم:</strong>
                                    <span>${newMessage.message}</span>
                                    <div class="small text-muted mt-1">${moment(newMessage.created_at).locale('ar').fromNow()}</div>
                                </div>
                            </div>`;

                        replyInput.value = '';
                        userMessages.scrollTop = userMessages.scrollHeight;
                    } else {
                        console.error('Failed to send reply:', response.statusText);
                        alert('فشل في إرسال الرد، حاول مرة أخرى.');
                    }
                } catch (error) {
                    console.error('Error sending reply:', error);
                    alert('حدث خطأ أثناء إرسال الرد.');
                }
            });

            window.loadUserMessages = loadUserMessages;
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/ar.min.js"></script>
@endsection
