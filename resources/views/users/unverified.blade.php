@if(!Auth::user()->isVerified())
    <status-bar type="warning">
        You have not verified your email yet. [USE files for text]
    </status-bar>
@endif
