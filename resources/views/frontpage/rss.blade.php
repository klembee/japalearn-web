<?xml version="1.0" encoding="UTF-8" ?>
<rss version="1.0" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <title>JapaLearn</title>
        <link>https://japalearn.com</link>
        <description>On the JapaLearn blog, we propose articles that will help you while learning the Japanese language</description>
        <language>en</language>
        @foreach(\App\Models\BlogPost::all() as $post)
            <item>
                <title>{!! $post->title !!}</title>
                <link>{{ route('frontpage.blog.view', $post) }}</link>
                <media:content url="{{$post->image_url}}" medium="image" />
                <description>{!! $post->meta_description !!}</description>
                <pubDate>{{ $post->created_at->format(DateTime::RSS) }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
