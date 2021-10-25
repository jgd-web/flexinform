@extends('layouts.app')

@section('title', 'Ügyfelek')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse">
            <form id="client-search" class="form-inline my-2 my-lg-0" name="client-search"
                  onsubmit="event.preventDefault();">
                <input id="client-name-search-input" class="form-control mr-sm-2" type="search" name="client_name"
                       placeholder="Ügyfél neve" aria-label="Ügyfél neve">
                <input id="idcard-search-input" class="form-control mr-sm-2" type="search" name="idcard"
                       placeholder="Okmányazonosító" aria-label="Okmányazonosító">
                <button class="btn btn-outline-success my-2 my-sm-0" id="client-search-submit">KERESÉS</button>
            </form>
        </div>
    </nav>
    <div id="search-result"></div>
    <table id="clients-table" class="table table-bordered table-sm mb-5">
        <thead>
        <tr>
            <th scope="col">ügyfél azonosító</th>
            <th scope="col">név</th>
            <th scope="col">okmányazonosító</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr class="client-row">
                <td class="client-id">{{ $client->id }}</td>
                <td class="client-name">
                    <a client-id="{{ $client->id }}" class="client-name-link" href="#">{{ $client->name }}</a>
                    <div id="client-{{ $client->id }}-cars"></div>
                </td>
                <td class="document-id">{{ $client->idcard }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $clients->links() }}
    </div>
    </div>
@endsection
