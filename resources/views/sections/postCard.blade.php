<div id="{{ 'post_'.$id }}" class="flex flex-1 rounded shadow-lg px-6 py-4">
    <div class="flex flex-col justify-between flex-1 font-bold text-xl mb-2">
        <div>{{ $title }}</div>
        <p class="text-gray-700 text-base">
            {{ $description }}
        </p>
    </div>
    <div class="flex flex-col">
        <button id="post_card_button_{{ $id }}">...</button>
        <form method="GET" action="/posts/{{ $id }}/edit">
            @csrf
            <button id="post_card_button_{{ $id }}_edit" class="hidden hover:bg-slate-400">edit</button>
        </form>

        <form id='post_delete_{{ $id }}' method='post' action="/posts/{{ $id }}">
            @csrf
            @method('DELETE')
            <button id="post_card_button_{{ $id }}_delete" class="hidden hover:bg-slate-400" class="hidden">delete
            </button>
        </form>
    </div>

</div>

<script>

    $(document).ready(function () {
        $("#post_card_button_{{ $id }}").on('click', function (e) {
            const isHidde = $('#post_card_button_{{ $id }}_edit').hasClass('hidden');
            if (isHidde) {
                $('#post_card_button_{{ $id }}_edit').removeClass('hidden');
                $('#post_card_button_{{ $id }}_delete').removeClass('hidden');
            } else {
                $('#post_card_button_{{ $id }}_edit').addClass('hidden');
                $('#post_card_button_{{ $id }}_delete').addClass('hidden');
            }
        })

        $("#post_card_button_{{ $id }}_delete").on('click', function (e) {
            const isDelete = confirm("確定要刪除這則貼文嗎");
            if (isDelete) {
                $('#post_delete_{{ $id }}').submit();
            }
        })
    })
</script>
