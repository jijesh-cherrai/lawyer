<div>
    @php
    $caseDiary = $record;
    $caseDetails = $record->caseDetails;
    $followups = $record->caseFollowup;
    @endphp
    <div class="flex w-full gap-4">
        <!-- Card 1 -->
        <div class="flex-1 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
            <!-- Card Header -->
            <div class="relative pb-3">
                <h2 class="text-xl font-semibold text-gray-950 dark:text-white">Case Details</h2>
                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gray-300 dark:bg-gray-600"></div>
            </div>
            <!-- Card Body -->
            <div class="mt-4">
                <div class="mt-2 flex justify-between text-gray-950 dark:text-white">
                    <span class="font-medium">Court</span>
                    <span>{{ $caseDiary->court->name }}</span>
                </div>
                <div class="mt-2 flex justify-between text-gray-950 dark:text-white">
                    <span class="font-medium">Party Names</span>
                    <span>{{ $caseDiary->party_names }}</span>
                </div>
                <div class="mt-2 flex justify-between text-gray-950 dark:text-white">
                    <span class="font-medium">Mobile</span>
                    <span>{{ $caseDiary->mobile }}</span>
                </div>
                <div class="mt-2 flex justify-between text-gray-950 dark:text-white">
                    <span class="font-medium">Opposit Lawyer</span>
                    <span>{{ $caseDiary->opposit_lawyer }}</span>
                </div>
                <div class="mt-2 flex justify-between text-gray-950 dark:text-white">
                    <span class="font-medium">Notes</span>
                    <span>{{ $caseDiary->notes }}</span>
                </div>
                <div class="mt-2 flex justify-between text-gray-950 dark:text-white">
                    <span class="font-medium">Next Hearing</span>
                    <span>{{ \Carbon\Carbon::parse($caseDiary->upcoming_case_date)->format('d M, Y')}}</span>
                </div>
                <div class="mt-2 flex justify-between text-gray-950 dark:text-white">
                    <span class="font-medium">Status</span>
                    <span>{{ ucwords($caseDiary->status) }}</span>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
            <!-- Card Header -->
            <div class="relative pb-3">
                <h2 class="text-xl font-semibold text-gray-950 dark:text-white">Case List</h2>
                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gray-300 dark:bg-gray-600"></div>
            </div>
            <!-- Card Body -->
            <div class="mt-4">
                @foreach($caseDetails as $list)
                <div class="mt-2 flex justify-between text-gray-950 dark:text-white">
                    <span class="font-medium">{{ $list->case_number }}({{ $list->caseType->type }})</span>
                </div>
                @endforeach

            </div>
        </div>

    </div>

    <h2 class="text-xl mt-4">Case Timeline</h2>
    <div class="bottom-0 left-0 w-full h-[2px] bg-gray-300 dark:bg-gray-600"></div>
    <div class="flex w-full gap-4 mt-6">
        <div class="space-y-8">

            @foreach($followups as $followup)
            <div style="margin-top: 10px;">
                <div class="md:flex items-center md:space-x-4 mb-3 mt-[5px]">
                    <div class="flex items-center space-x-4 md:space-x-2 md:space-x-reverse">
                        <!-- Icon -->
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-700 shadow md:order-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <!-- Date -->
                        <time style="margin-left: 10px;" class="font-caveat font-medium text-xl text-indigo-500 md:w-28">{{ \Carbon\Carbon::parse($followup->next_hearing)->format('d M, Y') }}
                        </time>
                    </div>
                    <!-- Title -->
                    <div class="text-slate-500" style="margin-left: 10px;"><span class="text-slate-900 font-bold pl-4">Attended by : {{$followup->advocate->name}}</span></div>
                </div>
                <!-- Card -->
                <div class="bg-white p-4 dark:bg-gray-800 rounded border border-slate-200 dark:border-gray-700 text-slate-500 shadow ml-14 md:ml-44">{{$followup->notes}}</div>
            </div>
            @endforeach
        </div>

    </div>

</div>