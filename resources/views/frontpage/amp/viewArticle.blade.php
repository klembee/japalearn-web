<!doctype html>
<html ⚡ lang="en-us">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="description" content="This is the AMP Boilerplate.">
    <link rel="preload" as="script" href="https://cdn.ampproject.org/v0.js">
    <link rel="preload" href="{{$post->image_url}}" as="image">
    <link rel="preconnect dns-prefetch" href="https://fonts.gstatic.com/" crossorigin>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <!-- Import other AMP Extensions here -->
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <style amp-custom>
        .content{
            padding-left:20px;
            padding-right:20px;
            font-family: 'Nunito', sans-serif;
            padding-bottom:60px;
        }

        h1{
            margin-bottom:5px;
        }

        .small{
            font-size:0.9em;
            margin-top:0;
        }

        .author-image{
            width:64px;
            border-radius: 100%;
            margin-right:10px;
        }

        .author{
            display:flex;
        }

    </style>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>

    <link rel="canonical" href="{{route('frontpage.blog.view', $post)}}">
    <title>JapaLearn - {{$post->title}}</title>
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "NewsArticle",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://google.com/article"
      },
      "headline": "Article headline",
      "image": [
        "{{$post->image_url}}",
      ],
      "datePublished": "{{$post->created_at}}",
      "dateModified": "{{$post->modified_at}}",
      "author": {
        "@type": "Person",
        "name": "{{$post->author->name}}"
      },
      "publisher": {
        "@type": "Organization",
        "name": "JapaLearn",
        "logo": {
          "@type": "ImageObject",
          "url": "https://japalearn.s3.ca-central-1.amazonaws.com/images/logo-v2.png"
        }
      },
      "description": "{{$post->meta_description}}"
    }
    </script>
</head>
<body>
<amp-img src="{{$post->image_url}}"
         width="1280"
         height="720"
         layout="responsive"
         alt="Image of the blog article">
</amp-img>
<amp-analytics type="gtag" data-credentials="include">
    <script type="application/json">
    {
      "vars" : {
        "gtag_id": "UA-165388196-1",
        "config" : {
          "UA-165388196-1": {
            "groups": "default"
          }
        }
      }
    }
    </script>
</amp-analytics>

<div class="content">
    <h1>{{$post->title}}</h1>
    <p class="small">Published on {{$post->formated_date}}</p>
    <hr />

    <div>
        {!! $parsedContent !!}
    </div>

    <hr />
    <h2>About the author</h2>
    <div class="author">
        <amp-img width="64" height="64" class="author-image" src="/storage/{{$post->author->profile_picture_url}}">

        </amp-img>
        <p class="author-bio">{{$post->author->bio}}</p>
    </div>
</div>

</body>
</html>
