@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar Venda</div>

                <div class="card-body">
                    <!-- Formulário para cadastrar nova venda -->
                    <form method="POST" action="{{ route('cadastrar.venda') }}">
                        @csrf

                        <div class="form-group">
                            <label for="produtos">Produtos Disponíveis:</label>
                            <select class="form-control" id="produtos" name="produtos[]" multiple required>
                                @foreach($celulares as $celular)
                                    <option value="{{ $celular->id }}">{{ $celular->name }} - R$ {{ number_format($celular->price, 2) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Cadastrar Venda</button>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">Vendas Realizadas</div>

                <div class="card-body">
                    <!-- Lista de vendas realizadas -->
                    <ul>
                        @foreach($vendas as $venda)
                            <li>
                                Venda ID: {{ $venda->id }} - Valor: R$ {{ number_format($venda->amount, 2) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection