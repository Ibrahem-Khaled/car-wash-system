<div class="modal fade" id="showSlideShowModal{{ $slideShow->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showSlideShowModalLabel{{ $slideShow->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showSlideShowModalLabel{{ $slideShow->id }}">تفاصيل الشريحة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $slideShow->image) }}" class="img-fluid rounded"
                        alt="{{ $slideShow->title }}">
                </div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">العنوان</th>
                            <td>{{ $slideShow->title }}</td>
                        </tr>
                        <tr>
                            <th>الوصف</th>
                            <td>{{ $slideShow->description ?? 'لا يوجد' }}</td>
                        </tr>
                        <tr>
                            <th>الحالة</th>
                            <td>
                                <span class="badge badge-{{ $slideShow->status == 'active' ? 'success' : 'danger' }}">
                                    {{ $slideShow->status == 'active' ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>الرابط</th>
                            <td>
                                @if ($slideShow->link)
                                    <a href="{{ $slideShow->link }}" target="_blank">{{ $slideShow->link }}</a>
                                @else
                                    لا يوجد
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>تاريخ الإنشاء</th>
                            <td>{{ $slideShow->created_at->diffForHumans() }}</td>
                        </tr>
                        <tr>
                            <th>آخر تحديث</th>
                            <td>{{ $slideShow->updated_at->diffForHumans() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
