<div class="py-5">
    <div class="container">
        <div class="flex justify-between items-center">
            <div>
                <img class="h-[40px] md:h-[80px]" src="{{ asset($company->logo) }}" alt="">
            </div>
            <div>
                <p class=" md:text-xl text-gray-600">{{ nepalidate(now()) }}</p>
                <img src="https://jawaaf.com/frontend/images/redline.png" class="h-[10px] md:h-[20px]" alt="">
            </div>
        </div>
    </div>
</div>
<div class="py-2 w-full rounded-md" >
    <form action="{{ route('search') }}" method="get">
        <input type="text" name="q" id="search">
        <button type="submit">Search</button>
</div>
</form>
