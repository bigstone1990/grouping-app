<p class="mb-4">{{$user->name}} 様</p>

<p class="mb-4">{{ config('app.name', 'Laravel') }}のユーザー登録が完了しました。</p>

<div class="mb-4">
  URL: <a href="https://grouper.fun">https://grouper.fun</a>
</div>

<div class="mb-4">
  初期パスワード: {{$password}}
</div>