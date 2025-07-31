<!-- Delete Message Modal -->
<div class="modal fade" id="deleteMessageModal{{ $message->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteMessageModalLabel{{ $message->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMessageModalLabel{{ $message->id }}">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من رغبتك في حذف هذه الرسالة نهائياً؟</p>
                <p class="text-danger">
                    <i class="fas fa-exclamation-triangle"></i> لا يمكن التراجع عن هذا الإجراء.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <form action="{{ route('contact-us.destroy', $message->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">نعم، احذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
