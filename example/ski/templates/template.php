<x-app x-data="{posts : datas.data.posts}">
  <x-article>
  <div>
    <x-comment x-data="{post : {username:'robert', content: 'nqsoirqpsigj'}}">
    </x-comment>
  </div>
  <template x-for="post in posts">
    <x-comment x-data="test">
  </template>
</x-app>
