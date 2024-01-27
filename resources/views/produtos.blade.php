@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar Produto</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('cadastrar.produto') }}">
                        @csrf

                        <div class="form-group">
                            <label for="nome">Nome do Produto</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição do Produto</label>
                            <textarea class="form-control" id="descricao" name="descricao"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="preco">Preço</label>
                            <input type="number" class="form-control" id="preco" name="preco" required>
                        </div>

                        <div class="form-group">
                            <label for="quantidade_estoque">Quantidade em Estoque</label>
                            <input type="number" class="form-control" id="quantidade_estoque" name="quantidade_estoque" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection