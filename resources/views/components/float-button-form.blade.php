<div>
    @auth
        <!-- Floating Chat Button -->
        <button id="chatButton" class="btn btn-lg rounded-circle shadow-lg position-fixed"
            style="bottom: 20px; left: 20px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-color: #ed0f7d; color: white;">
            <i class="fa fa-comments"></i>
        </button>

        <!-- Chat Modal -->
        <div id="chatModal" class="modal fade" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header" style="background-color: #4a2f85; color: white;">
                        <h5 class="modal-title fw-bold" id="chatModalLabel">
                            <i class="fa fa-comments me-2"></i> الدردشة
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body" style="background-color: #f8f8f8;">
                        <div id="chatMessages" class="overflow-auto border rounded p-3 mb-3"
                            style="height: 300px; background-color: white;">
                            <!-- سيتم تحميل الرسائل من خلال JavaScript -->
                        </div>
                        <form id="chatForm" class="d-flex">
                            @csrf
                            <input type="text" id="chatInput" name="message" placeholder="اكتب رسالتك..."
                                class="form-control me-2 rounded-pill shadow-sm" style="border: 2px solid #4a2f85;">
                            <button type="submit" class="btn px-4 shadow-sm"
                                style="background-color: #ed0f7d; color: white; border-radius: 50px;">إرسال</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Login Button -->
        <button onclick="window.location.href='{{ route('login') }}'"
            class="btn btn-lg rounded-circle shadow-lg position-fixed"
            style="bottom: 20px; right: 20px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-color: #ed0f7d; color: white;">
            <i class="fa fa-sign-in-alt"></i>
        </button>
    @endauth
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatButton = document.getElementById('chatButton');
        const chatModal = new bootstrap.Modal(document.getElementById('chatModal'));
        const chatMessages = document.getElementById('chatMessages');
        const chatForm = document.getElementById('chatForm');
        const chatInput = document.getElementById('chatInput');

        // عرض نافذة الدردشة وجلب الرسائل
        chatButton.addEventListener('click', async () => {
            chatModal.show();

            // جلب الرسائل من السيرفر
            const response = await fetch('{{ route('chat.messages') }}');
            if (response.ok) {
                const messages = await response.json();
                chatMessages.innerHTML = ''; // تفريغ الرسائل السابقة
                messages.forEach(message => {
                    const isSupport = message.sender_type === 'support';
                    const alignment = isSupport ? 'text-start' :
                    'text-end'; // الدعم يسار والمستخدم يمين
                    const bgColor = isSupport ?
                        'background-color: #ed0f7d; color: white;' : // لون الدعم
                        'background-color: #4a2f85; color: white;'; // لون المستخدم

                    // عرض الرسالة الأصلية إذا كان هناك رد
                    let repliedToMessage = '';
                    if (message.reply_to && message.original_message) {
                        repliedToMessage = `
                <div class="small text-muted mb-1" style="font-style: italic;">
                    رد على: "${message.original_message.message}"
                </div>`;
                    }

                    // تنسيق "منذ متى"
                    const timeAgo = moment(message.created_at).locale('ar').fromNow();

                    chatMessages.innerHTML += `
            <div class="${alignment} mb-3">
                <div class="d-inline-block p-2 rounded" style="max-width: 70%; ${bgColor}">
                    ${repliedToMessage}
                    <strong>${isSupport ? 'الدعم' : message.user.name}:</strong>
                    <span>${message.message}</span>
                    <div style="color: #ccc;" class="small mt-1">${timeAgo}</div>
                </div>
            </div>`;
                });

                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });

        // إرسال الرسائل
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = chatInput.value;

            const response = await fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    message
                })
            });

            if (response.ok) {
                const newMessage = await response.json();
                const isCurrentUser = true;
                const alignment = isCurrentUser ? 'text-end' : 'text-start';
                const bgColor = isCurrentUser ? 'bg-primary text-white' : 'bg-light';
                chatMessages.innerHTML += `
            <div class="${alignment} mb-3">
                <div class="d-inline-block p-2 rounded ${bgColor}" style="max-width: 70%;">
                    <strong>{{ auth()->user()->name }}:</strong>
                    <span>${newMessage.message}</span>
                </div>
            </div>`;
                chatInput.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    });
</script>
