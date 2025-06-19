@extends('layout.produksi.main')

@section('title')
    @if (Auth::user()->role == 0)
        Job Card || Admin
    @elseif (Auth::user()->role == 1)
        Job Card || Pegawai
    @endif
@endsection

@section('pages')
@php
    $cc = \App\Models\JobCardM::where('id',$id)->value('no_jobcard');
@endphp
    Add Material || {{$cc}}
@endsection

@section('content')
<div class="card">
<div class="container-fluid mt-0">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li style="color: white">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form action="{{ route('pengadaan.jobcard.detail.store') }}" method="POST">
            @csrf

            <div class="form-group mt-3">
                <input type="hidden" value="{{ $id }}" name="job_card_id">
                <label for="description">Description</label>
                <select class="form-control" id="description" name="description" required style="outline: 1px solid #007bff;">
                    <option value="" selected disabled>&nbsp;&nbsp;&nbsp;--Select Material--</option>
                    @foreach ($material as $m)
                        <option value="{{ $m->name }}" 
                                data-id="{{ $m->id }}" 
                                data-unit-price="{{ $m->unit_price }}" 
                                data-stok="{{ $m->stok }}" 
                                data-buying-price="{{ $m->buying_price }}" 
                                data-supplier="{{ $m->supplier }}">{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id">Material ID</label>
                <input type="text" class="form-control" id="id" name="id" required readonly>
            </div>

            <div class="form-group">
                <label for="qty">Quantity</label>
                <input type="number" min="1" class="form-control" id="qty" name="qty" required style="outline: 1px solid #007bff;">
            </div>

            <div class="form-group">
                <label for="unit_bop">Unit BOP</label>
                <input type="text" class="form-control" id="unit_bop_display" readonly>
                <input type="hidden" id="unit_bop" name="unit_bop">
            </div>

            <div class="form-group">
                <label for="total_bop">Total BOP</label>
                <input type="text" class="form-control" id="total_bop_display" readonly>
                <input type="hidden" id="total_bop" name="total_bop">
            </div>

            <div class="form-group">
                <label for="unit_sp">Unit SP</label>
                <input type="text" class="form-control" id="unit_sp_display" name="unit_sp" required style="outline: 1px solid #007bff;" placeholder="Rp. xxx.xxx">
            </div>

            <div class="form-group">
                <label for="total_sp">Total SP</label>
                <input type="text" class="form-control" id="total_sp_display" readonly>
                <input type="hidden" id="total_sp" name="total_sp">
            </div>

            <div class="form-group">
                <label for="unit_bp">Unit BP</label>
                <input type="text" class="form-control" id="unit_bp_display" readonly>
                <input type="hidden" id="unit_bp" name="unit_bp">
            </div>

            <div class="form-group">
                <label for="total_bp">Total BP</label>
                <input type="text" class="form-control" id="total_bp_display" readonly>
                <input type="hidden" id="total_bp" name="total_bp">
            </div>

            <div class="form-group">
                <label for="supplier">Supplier</label>
                <input type="text" class="form-control" id="supplier" name="supplier" readonly required>
            </div>

            <div class="form-group">
                <label for="remarks">Remarks</label>
                <input type="text" class="form-control" id="remarks" name="remarks" style="outline: 1px solid #007bff;">
            </div>
            <input type="hidden" id="ids" value="{{$id}}">
            <div class="mt-3">
                <a href="{{ route('pengadaan.jobcard') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Save Material</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ids = document.getElementById('ids');
        const descriptionSelect = document.getElementById('description');
        const materialId = document.getElementById('id');
        const qtyInput = document.getElementById('qty');
        const unitBopInput = document.getElementById('unit_bop');
        const totalBopInput = document.getElementById('total_bop');
        const unitBpInput = document.getElementById('unit_bp');
        const totalBpInput = document.getElementById('total_bp');
        const unitSpInput = document.getElementById('unit_sp_display');
        const totalSpInput = document.getElementById('total_sp');
        const supplierInput = document.getElementById('supplier');

        const unitBopDisplay = document.getElementById('unit_bop_display');
        const totalBopDisplay = document.getElementById('total_bop_display');
        const unitBpDisplay = document.getElementById('unit_bp_display');
        const totalBpDisplay = document.getElementById('total_bp_display');
        const totalSpDisplay = document.getElementById('total_sp_display');

        descriptionSelect.addEventListener('change', function () {
            const selectedOption = descriptionSelect.options[descriptionSelect.selectedIndex];
            const unitPrice = parseFloat(selectedOption.getAttribute('data-unit-price')) || 0;
            const buyingPrice = parseFloat(selectedOption.getAttribute('data-buying-price')) || 0;
            const maxQty = parseFloat(selectedOption.getAttribute('data-stok')) || 0;
            const supplier = selectedOption.getAttribute('data-supplier') || '';
            const id = selectedOption.getAttribute('data-id');

            qtyInput.max = maxQty;
            unitBopDisplay.value = formatRupiah(unitPrice);
            unitBopInput.value = unitPrice;
            unitBpDisplay.value = formatRupiah(buyingPrice);
            unitBpInput.value = buyingPrice;
            supplierInput.value = supplier;
            materialId.value = id;
            qtyInput.value = '';
            totalSpDisplay.value = '';
            totalSpInput.value = '';
        });

        qtyInput.addEventListener('input', function () {
            const qty = parseFloat(qtyInput.value) || 0;
            const maxQty = parseFloat(descriptionSelect.options[descriptionSelect.selectedIndex].getAttribute('data-stok')) || 0;

            if (qty > maxQty) {
                Swal.fire({
                    title: 'Stock Unavailable',
                    text: 'Please reduce the quantity. Stock is insufficient.max stok : '. maxQty,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Procure Material',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('pengadaan.jobcard.pengadaan', ['','','']) }}/" + ids.value + "/" + qtyInput.value + "/" + materialId.value;
                    } else {
                        qtyInput.value = maxQty;
                    }
                });
                return;
            }

            const unitBop = parseFloat(unitBopInput.value) || 0;
            const totalBop = qty * unitBop;
            totalBopDisplay.value = formatRupiah(totalBop);
            totalBopInput.value = totalBop;

            const unitBp = parseFloat(unitBpInput.value) || 0;
            const totalBp = qty * unitBp;
            totalBpDisplay.value = formatRupiah(totalBp);
            totalBpInput.value = totalBp;

            const unitSp = parseCurrency(unitSpInput.value);
            const totalSp = qty * unitSp;
            totalSpDisplay.value = formatRupiah(totalSp);
            totalSpInput.value = totalSp;
        });

        unitSpInput.addEventListener('input', function () {
            const qty = parseFloat(qtyInput.value) || 0;
            const unitSp = parseCurrency(unitSpInput.value);
            const totalSp = qty * unitSp;
            totalSpDisplay.value = formatRupiah(totalSp);
            totalSpInput.value = totalSp;
        });

        function formatRupiah(value) {
            return 'Rp ' + value.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function parseCurrency(value) {
            return parseFloat(value.replace(/[^\d]/g, '')) || 0;
        }
    });
</script>

@endsection
