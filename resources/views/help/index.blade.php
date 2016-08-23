@extends('layouts.app')

@section('content')
    <div class="o-content o-content--max-width">
        <h1 class="o-headline o-headline--first">FAQ & Help Section</h1>
        <p class="o-copy o-content__paragraph">Should you have any issues that can not be resolved using the answers on this page, please contact <a class="o-link" href="mailto:support@formandsystem.com">support@formandsystem.com</a>.</p>
        <h2 class="o-headline o-headline--second">What are collections</h2>
        <p class="o-copy o-content__paragraph">Content is group in collections, you can for example have a collection for your main pages and another collection that holds all your news articles.</p>
        <p class="o-copy o-content__paragraph">To create a new collection click the "+ New Collection" button. You will be able to create a "Pages" collection in which you can create new pages or a collection that holds a specific type of small content bits, like news posts.</p>
        <h2 class="o-headline o-headline--second">Save changes</h2>
        <p class="o-copy o-content__paragraph">To make changes show up on the live website you need to click the <strong>Refresh Cache</strong> button on the bottom of the main menu.</p>
        <h2 class="o-headline o-headline--second">Markdown</h2>
        <p class="o-copy o-content__paragraph">Markdown is a very flexible structure based text format. The idea is that you can write and just focus on the structure of your content, not the design.</p>
        <p class="o-copy o-content__paragraph">Markdown is applied using special characters. For your convenience a menu is shown when you select text, so that you can select the format this texts needs to be in.</p>
        <h3 class="o-headline o-headline--third">Headlines</h3>
        <p class="o-copy o-content__paragraph">Headlines are specified by one or more #, where one # will create an H1 and 3 will create an H3</p>
        <p class="o-copy o-content__paragraph">
        # H1<br />
        ## H2<br />
        ### H3<br />
        #### H4<br />
        ##### H5<br />
        ###### H6<br />
        </p>
        <h3 class="o-headline o-headline--third">Lists</h3>
        <p class="o-copy o-content__paragraph">Lists are created by simply prefixing a list item with a -.</p>
        <p class="o-copy o-content__paragraph">
        - list item 1<br />
        - list item 2<br />
        </p>
        <h3 class="o-headline o-headline--third">Blockquote</h3>
        <p class="o-copy o-content__paragraph">Blockquotes are created by prefixing a paragraph with a >. By prefixing a list item with two >> you can create a 2nd level blockquote.</p>
        <p class="o-copy o-content__paragraph">
        > blockquote<br />
        >> 2nd level blockquote<br />
        </p>
        <h3 class="o-headline o-headline--third">Links</h3>
        <p class="o-copy o-content__paragraph">Links are created by wrapping the link text in [] and the actual link in () without any space between the two.</p>
        <p class="o-copy o-content__paragraph">
        [I'm an inline-style link](http://www.formandsystem.com)
        </p>
        <h3 class="o-headline o-headline--third">Strong and italic text</h3>
        <p class="o-copy o-content__paragraph">By surrounding text with one _ (no space) it will be italic. While using two ** on either side will make it strong.</p>
        <p class="o-copy o-content__paragraph">
            _italic text_<br />
            **strong/bold text**<br />
        </p>
        <h2 class="o-headline o-headline--second">Uploading images</h2>
        <p class="o-copy o-content__paragraph">To upload an image first create a new image fragment. Afterwards click the "Upload image" button. Select an image from your computer and wait until it appears. Please do not leave the page or edit it until the image is uploaded, as this might cancel the upload.</p>
    </div>
@stop
