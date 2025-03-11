<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Deals</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900">
    <!-- Navbar -->
    <nav
        class="fixed top-0 left-1/2 transform -translate-x-1/2 p-4 flex justify-start items-center space-x-6 z-50  bg-[#205781] w-full ">
        <a href="{{ $path }}" class="text-2xl text-white font-bold">&#x2190;</a>
    </nav>

    <!-- Layout -->
    <div class="p-6 pt-20 grid grid-cols-1 md:grid-cols-3 gap-6 w-full container mx-auto ">
        <!-- รูปภาพใหญ่ -->
        <div class="md:col-span-2 h-full">
            <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg"
                class="w-full h-[400px] object-cover rounded-lg shadow-md">
        </div>

        <!-- ข้อมูลด้านขวา -->
        <div class="bg-white p-4 rounded-lg shadow-md flex flex-col items-center w-full max-w-md mx-auto h-[400px]">
            <!-- หัวข้อ Quantity -->
            <div class="bg-blue-900 text-white text-xl font-bold w-full text-center py-3 shadow-sm rounded-md">
                <p class="text-2xl">{{ ucwords($productData->name) }}<br>Quantity : {{ $productData->tour_capacity }}
                    Person</p>
            </div>

            <!-- รายละเอียด Children / Adults -->
            <div class="flex justify-center w-full py-12">
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Reserved</h3>
                    <p class="text-2xl">{{ is_null($totalMember)? 0: $totalMember}}/{{ $productData->tour_capacity }}</p>
                </div>
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Status</h3>
                        <p class="text-2xl text-green-500">FINISH</p>
                </div>
            </div>

            <!-- ปุ่ม -->
            <div class="flex gap-4 w-full">
                <div class="bg-blue-900 text-white px-6 py-8 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl">
                    Hotel <br><span class="italic font-normal text-base">
                    @if (is_null($productData->hotel))
                        Not Have Hotel
                    @else
                        {{$productData->hotel}}({{$productData->hotel_price}}/DAY)
                    @endif
                </span>
                </div>
                <div class="bg-blue-900 text-white px-6 py-8 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl">
                    Travel By<br>
                    @if (is_null($productData->travel_by))
                        -
                    @else
                        <p class="text-xl font-bold">{{ucwords($productData->travel_by)}}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- กล่องข้อมูลด้านล่าง -->
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 w-full container mx-auto">
        <!-- กล่องซ้าย: ข้อมูลหลัก -->
        <div class="flex flex-col gap-4">
            <!-- Grid ของ Start-End Date, Post Date, Price -->
            <div class="grid grid-cols-3 gap-4 bg-white p-6 rounded-lg shadow-md">
                <div>
                    <p class="font-bold">Start - End Date</p>
                    <div class="bg-blue-900 text-white px-4 py-2 text-center rounded-lg inline-block shadow-md">
                        {{ $productData->start_tour_date}}<br>To<br>{{$productData->end_tour_date}}
                    </div>
                </div>
                <div>
                    <p class="font-bold">Post Date</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg inline-block shadow-md">
                        {{ $productData->Release_date }}
                    </div>
                </div>
                <div>
                    <p class="font-bold">Price</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg inline-block shadow-md">
                        {{ number_format($productData->price) }}
                    </div>
                </div>
            </div>

            <!-- Owner of post และ Description -->
            <div class="bg-white p-6 rounded-lg shadow-md h-[300px]">
                <p class="font-bold">Owner of post : <span class="font-normal">
                        @if ($productData->from_owner === 'guide')
                            {{ $productData->guide_name.' '.$productData->guide_surname }}
                        @else
                            {{ $productData->corp_name}}
                        @endif
                    </span></p>
                <p class="font-bold mt-2">Description:</p>
                <p class="mt-2">{{ $productData->description}}</p>
            </div>
        </div>

        <!-- กล่องขวา: Quantity และปุ่ม -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <h2 class="font-bold text-xl p-2">Location List</h2>
        </div>
    </div>

    <!-- รีวิวลูกค้า -->
    <div class="bg-white py-6 px-6 rounded-lg shadow-md mt-4 w-[1485px] mx-auto mb-10">
        <h4 class="text-2xl font-bold mb-3">Reviews</h4>

        <!-- กล่องรีวิวแบบเลื่อน -->
        <div class="max-h-[300px] overflow-y-auto space-y-2 p-2 bg-gray-50 rounded-lg shadow-inner">
            @foreach ($myReview as $review)
                <div class="bg-green-100 p-3 rounded-lg shadow-sm">
                    <strong>{{ session('userID')->name.' '.session('userID')->surname.'(Tour&Guide Review)'}}:</strong>
                    <p>{{ $review->message }}
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $review->score)
                                <span class=text-lg>⭐</span>
                            @else
                                <span class=text-lg>☆</span>
                            @endif
                        @endfor
                        <span class=text-lg>(for tour)</span>
                    </p>
                    @if (!is_null($review->guide_list_account_id_account))
                    <p>{{ $review->guideReviewMessage }}
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $review->sp_score)
                                <span class=text-lg>⭐</span>
                            @else
                                <span class=text-lg>☆</span>
                            @endif
                        @endfor
                        <span class=text-lg>(for guide)</span>
                    </p>
                    @endif
                </div>
            @endforeach
            @foreach ($anotherReview as $review)
                <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                    <strong>{{ $review->name.' '.$review->surname }}:</strong>
                    <p>{{ $review->message}}
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $review->score)
                                <span class=text-lg>⭐</span>
                            @else
                                <span class=text-lg>☆</span>
                            @endif
                        @endfor
                    </p>
                </div>
                @if (!is_null($review->guide_list_account_id_account))
                <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                    <strong>{{ $review->name.' '.$review->surname}}:</strong>
                    <p>{{ $review->guideReviewMessage}}
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $review->sp_score)
                                <span class=text-lg>⭐</span>
                            @else
                                <span class=text-lg>☆</span>
                            @endif
                        @endfor
                    </p>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    <script>
        const minBudgetInput = document.getElementById("min_budget");
        const maxBudgetInput = document.getElementById("max_budget");
        const minValueSpan = document.getElementById("min_value");
        const maxValueSpan = document.getElementById("max_value");

        function updateMinValue(value) {
            document.getElementById("min_value").innerText = parseInt(value).toLocaleString();
            maxBudgetInput.min = value; // อัปเดต min ของ max_budget
            if (parseInt(maxBudgetInput.value) < parseInt(value)) {
                maxBudgetInput.value = value;
                document.getElementById("max_value").innerText = parseInt(value).toLocaleString();
            }
        }

        function updateMaxValue(value) {
            document.getElementById("max_value").innerText = parseInt(value).toLocaleString();
        }
    </script>
</body>

</html>
