@extends('layouts.master')

@section('title')
انشاء أكلة جديد
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأكلات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأكلات @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('products.index') }} @endslot
        @slot('li3') انشاء أكلة جديد @endslot
    @endcomponent
    <div class="create_product">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء أكلة جديد
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">أسم الأكلة</label>
                                    <input type="text" class="form-control @error('name')is-invalid @enderror" name="name"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if(Auth::user()->type == 'admin')
                                <div class="col-6 branch_col">
                                    <div class="form-group">
                                        <label for="branch">الفرع</label>
                                        <select class="form-control select2 branch_select" name="branch_id">
                                            <option value="">أختر الفرع</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" @if (old('branch_id') == $branch->id) selected @endif>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 categories_col @if(old('branch_id')) @else d-none @endif">
                                    <div class="form-group">
                                        <label for="category">أسم الصنف</label>
                                        <select class="form-control select2 categories_select" name="category_id">
                                            <option value="">أختر الصنف</option>
                                        </select>
                                        @error('category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                                <div class="col-12 col-md-6 categories_col">
                                    <div class="form-group">
                                        <label for="category">أسم الصنف</label>
                                        <select class="form-control select2 categories_select" name="category_id">
                                            <option value="">أختر الصنف</option>
                                        </select>
                                        @error('category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">صور الأكلة</label>
                                    <input type="file" class="form-control input_files" accept="image/*" multiple hidden
                                        name="photos[]">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="text-danger file_error" hidden>يجب أختيار أقصى عدد للصور 5</div>
                                    <div class="imgs mt-2 d-flex"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">وصف الأكلة</label>
                                    <textarea id="textarea" class="form-control" name="description" maxlength="225"
                                        rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            @if(!old('sizes'))
                                <div class="col-12 col-md-6 on_extra">
                                    <div class="form-group">
                                        <label for="name">السعر</label>
                                        <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 on_extra">
                                    <div class="form-group">
                                        <label for="name">الخصم</label>
                                        <input type="text" class="form-control" value="0" name="discount"
                                            value="{{ old('discount') }}">
                                        @error('discount')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">رقم الظهور</label>
                                    <input type="number" class="form-control" value="1" name="viewed_number"
                                        value="{{ old('viewed_number') }}">
                                    @error('viewed_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="extras">اضافات</label>
                                    <select name="extras_type[]" class="form-control extras select2 select2-multiple"
                                        data-placeholder="أختر الأضافة" multiple>
                                        <option value="extra" @if(is_array(old('extras_type')) && in_array('extra', old('extras_type'))) selected @endif>اضافات على الأكل</option>
                                        <option value="size" @if(is_array(old('extras_type')) && in_array('size', old('extras_type'))) selected @endif>مقاسات</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 tables">
                                @if(old('extras'))
                                    <table class="table extra-table">
                                        <thead>
                                            <th>الأضافة</th>
                                            <th>السعر</th>
                                            <th>
                                                <button type="button" class="btn btn-success add-extra">اضافة</button>
                                            </th>
                                        </thead>
                                        <tbody>
                                            @foreach (old('extras') as $key => $value)
                                                <tr>
                                                    <td>
                                                        <input class="form-control" name="extras[{{ $key }}][variant]" value="{{ $value['variant'] }}" placeholder="الأضافة" type="text">
                                                        @error("extras.$key.variant")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="extras[{{ $key }}][price]" value="{{ $value['price'] }}" placeholder="السعر" type="text">
                                                        @error("extras.$key.price")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    @if(count(old('extras')) > 1 && $key !== 0)
                                                    <td>
                                                        <button type="button" class="btn btn-danger remove-extra">
                                                            <span>ازالة</span>
                                                            <i class="mdi mdi-trash-can-outline"></i>
                                                        </button>
                                                    </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @if(old('sizes'))
                                    <table class="table size-table">
                                        <thead>
                                            <th>المقاس</th>
                                            <th>السعر</th>
                                            <th>الخصم</th>
                                            <th>السعر بعد الخصم</th>
                                            <th>
                                                <button type="button" class="btn btn-success add-size">اضافة</button>
                                            </th>
                                        </thead>
                                        <tbody>
                                            @foreach (old('sizes') as $key => $value)
                                                <tr>
                                                    <td>
                                                        <input class="form-control" name="sizes[{{ $key }}][variant]" value="{{ $value['variant'] }}" placeholder="المقاس" type="text">
                                                        @error("sizes.$key.variant")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input class="form-control price-input" name="sizes[{{ $key }}][price]" value="{{ $value['price'] }}" onkeyup="getFullPrice(this)" placeholder="السعر" type="text">
                                                        @error("sizes.$key.price")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input class="form-control discount-input" name="sizes[{{ $key }}][discount]"  value="{{ $value['discount'] }}" onkeyup="getFullPrice(this)"  placeholder="الخصم" type="text">
                                                        @error("sizes.$key.discount")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <h6 class="price_after_disount">
                                                            @if(is_numeric($value['price']) && is_numeric($value['discount']))
                                                                {{ $value['price'] - $value['discount'] }}
                                                            @endif
                                                        </h6>
                                                    </td>
                                                    @if(count(old('sizes')) > 1 && $key !== 0)
                                                    <td>
                                                        <button type="button" class="btn btn-danger remove-size">
                                                            <span>ازالة</span>
                                                            <i class="mdi mdi-trash-can-outline"></i>
                                                        </button>
                                                    </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="مرئى">مرئى</label>
                                <div class="form-group">
                                    <input type="checkbox" name="active" id="switch4" switch="bool" checked />
                                    <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="أنشاء" class="btn btn-success">
                                    <a href="{{ route('products.index') }}" class="btn btn-info">رجوع الى الأكلات</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
    <script>
        let extraIndex = 0,
        sizeIndex = 0;
        let price = `
        <div class="col-12 col-md-6 on_extra">
            <div class="form-group">
                <label for="name">السعر</label>
                <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        `;
        let discount = `
        <div class="col-12 col-md-6 on_extra">
            <div class="form-group">
                <label for="name">الخصم</label>
                <input type="text" class="form-control" name="discount"
                    value="{{ old('discount') }}">
                @error('discount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        `;
        let extras = `
        <table class="table extra-table">
            <thead>
                <th>الأضافة</th>
                <th>السعر</th>
                <th>
                    <button type="button" class="btn btn-success add-extra">اضافة</button>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input class="form-control" name="extras[0][variant]" placeholder="الأضافة" type="text">
                        @error('extras')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <input class="form-control" name="extras[0][price]" placeholder="السعر" type="text">
                    </td>
                </tr>
            </tbody>
        </table>
        `;
        let sizes = `
        <table class="table size-table">
            <thead>
                <th>المقاس</th>
                <th>السعر</th>
                <th>الخصم</th>
                <th>السعر بعد الخصم</th>
                <th>
                    <button type="button" class="btn btn-success add-size">اضافة</button>
                </th>
            </thead>
            <tbody>
                ${tr(0, 'size')}
            </tbody>
        </table>
        `;

        function getCategoriesByBranchVal(val) {
            let token = $("meta[name=_token]").attr('content');
            $.ajax({
                method: "POST",
                url: "{{ route('categories.all') }}",
                data: {
                    _token: token,
                    branch_id: val
                },
                success: function(res) {
                    if(res.status) {
                        let data = res.data.map((obj) => {
                            return {
                                id: obj.id,
                                text: obj.name
                            }
                        });
                        data.unshift({id: '', text: 'أختر الصنف'})
                        $(".categories_col").removeClass('d-none');
                        $(".categories_select").html('').select2({data: data});
                    } else {
                        toastr.error('يوجد خطأ ما');
                    }
                },
                error: function(err) {
                    console.log(err)
                }
            })
        }

        getCategoriesByBranchVal("{{ Auth::user()->branch_id }}");

        $(".branch_select").on('change', function() {
            getCategoriesByBranchVal($(this).val());
        });

        function tr(index, type) {
            let name = '',
                sizeTD = '',
                removeTd = '',
            variant = '';
            if(type == 'extra') {
                name = 'extras';
                variant = 'الأضافة';
            } else if(type == 'size') {
                name = 'sizes';
                variant = 'المقاس';
                sizeTD = `
                    <td>
                        <input class="form-control discount-input" name="${name}[${index}][discount]" value="0" onkeyup="getFullPrice(this)"  placeholder="الخصم" type="text">
                    </td>
                    <td>
                        <h6 class="price_after_disount"></h6>
                    </td>
                `;
            }
            if(index !== 0) {
                removeTd = `
                    <td>
                        <button type="button" class="btn btn-danger remove-${type}">
                            <span>ازالة</span>
                            <i class="mdi mdi-trash-can-outline"></i>
                        </button>
                    </td>
                `;
            } else {
                removeTd = '';
            }
            return `
            <tr>
                <td>
                    <input class="form-control" name="${name}[${index}][variant]" placeholder="${variant}" type="text">
                </td>
                <td>
                    <input class="form-control price-input" name="${name}[${index}][price]" onkeyup="getFullPrice(this)" placeholder="السعر" type="text">
                </td>
                ${sizeTD}
                ${removeTd}
            </tr>
        `;
        }
        $(".extras").on('change', function() {
            arrayOfValues = $(this).val();
            if (arrayOfValues.length == 0) {
                $(".extras").parent().parent().before(price);
                $(".extras").parent().parent().before(discount);
            }
            if (arrayOfValues.includes('extra')) {
                if($(".extra-table").find('tbody').children().length == 0) {
                    $('.tables').prepend(extras);
                    addRow('extra');
                }
            } else {
                $(".extra-table").remove();
            }
            if (arrayOfValues.includes('size')) {
                $(".on_extra").remove();
                if($(".size-table").find('tbody').children().length == 0) {
                    $('.tables').prepend(sizes);
                    addRow('size');
                }
            } else {
                $(".size-table").remove();
            }
        });
        function addRow(type) {
            $(`.add-${type}`).on('click', function() {
                let index = $(`.${type}-table`).find('tbody').children().length;
                $(`.${type}-table`).find('tbody').append(tr(index, type));
                removeRow(type);
            });
        }
        function removeRow(type) {
            $(`.remove-${type}`).on('click', function() {
                $(this).parent().parent().remove();
            });
        }
        removeRow('extra');
        removeRow('size');
        addRow('extra');
        addRow('size');

        function getFullPrice(input) {
            let tr = $(input).parent().parent(),
                priceInputVal = parseFloat($(tr).find('.price-input').val()),
                discountInputVal = parseFloat($(tr).find('.discount-input').val());
                console.log(priceInputVal)
                if(isNaN(discountInputVal)) {
                    discountInputVal = 0;
                }
                console.log($(tr).find('.price-input'));
                // console.log(discountInputVal);
            $(tr).find('.price_after_disount').text((priceInputVal - discountInputVal));
        }
    </script>
@endsection
