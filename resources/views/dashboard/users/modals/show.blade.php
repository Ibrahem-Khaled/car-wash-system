<div class="modal fade" id="showUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="showUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل المستخدم: {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 text-center border-end">
                        <img src="{{ Str::startsWith($user->image, 'http') ? $user->image : asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover;">
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted">{{ $roleNames[$user->role] ?? ucfirst($user->role) }}</p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                             <span class="badge fs-6 bg-{{ $user->status == 'active' ? 'success' : 'danger' }}-subtle text-{{ $user->status == 'active' ? 'success' : 'danger' }}-emphasis">
                                {{ $user->status == 'active' ? 'نشط' : 'غير نشط' }}
                            </span>
                            <span class="badge fs-6 bg-primary-subtle text-primary-emphasis">
                                {{ $user->points }} نقاط
                            </span>
                        </div>
                         <div class="mt-3">
                            <strong>تاريخ الانضمام:</strong>
                            <p class="text-muted">{{ $user?->created_at?->format('Y-m-d h:i A') }}</p>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <ul class="nav nav-pills mb-3" id="pills-tab-{{$user->id}}" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-details-tab-{{$user->id}}" data-toggle="pill" data-target="#pills-details-{{$user->id}}" type="button" role="tab">التفاصيل</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-qr-tab-{{$user->id}}" data-toggle="pill" data-target="#pills-qr-{{$user->id}}" type="button" role="tab">رمز QR</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent-{{$user->id}}">
                            <div class="tab-pane fade show active" id="pills-details-{{$user->id}}" role="tabpanel">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="fw-bold" width="30%">البريد الإلكتروني</td>
                                        <td>{{ $user->email ?? 'لا يوجد' }}</td>
                                    </tr>
                                     <tr>
                                        <td class="fw-bold">حالة البريد</td>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="text-success">موثق</span>
                                            @else
                                                <span class="text-danger">غير موثق</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">الهاتف</td>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">العنوان</td>
                                        <td>{{ $user->address ?? 'غير محدد' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">المدينة</td>
                                        <td>{{ $user->city ?? 'غير محددة' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Expo Push Token</td>
                                        <td style="word-break: break-all;">{{ $user->expo_push_token ?? 'لا يوجد' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane fade text-center" id="pills-qr-{{$user->id}}" role="tabpanel">
                                @if($user->qr_code_identifier && isset($user->qrCodeUrl))
                                    <div class="p-3">
                                        {!! QrCode::size(200)->generate($user->qrCodeUrl) !!}
                                        <p class="mt-2 text-muted small">امسح الكود لعرض الملف الشخصي</p>
                                    </div>
                                @else
                                    <p class="text-muted mt-5">لا يوجد رمز QR لهذا المستخدم.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
