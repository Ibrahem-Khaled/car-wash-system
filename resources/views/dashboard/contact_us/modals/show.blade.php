<!-- Show Message Modal -->
<div class="modal fade" id="showMessageModal{{ $message->id }}" tabindex="-1" role="dialog" aria-labelledby="showMessageModalLabel{{ $message->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showMessageModalLabel{{ $message->id }}">تفاصيل الرسالة من: {{ $message->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>الاسم:</strong> {{ $message->name }}
                </div>
                <div class="mb-3">
                    <strong>البريد الإلكتروني:</strong> <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                </div>
                <div class="mb-3">
                    <strong>رقم الهاتف:</strong> <a href="tel:{{ $message->phone }}">{{ $message->phone }}</a>
                </div>
                <hr>
                <div>
                    <h5>نص الرسالة:</h5>
                    <p class="text-muted" style="white-space: pre-wrap;">{{ $message->message }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
