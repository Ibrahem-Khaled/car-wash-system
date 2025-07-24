<div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id }}">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من أنك تريد حذف المستخدم <strong class="text-danger">{{ $user->name }}</strong>؟
                    </p>
                    <p class="text-danger">لا يمكن التراجع عن هذا الإجراء!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">نعم، احذف</button>
                </div>
            </form>
        </div>
    </div>
</div>
