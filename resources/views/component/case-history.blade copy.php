<div>
    @php
    $case = $record;
    $caseList = $record->caseDetails->toArray();
    $followups = $record->caseFollowup;
    @endphp
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Main Case Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-800 dark:text-gray-100">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">Case Details</h3>
                        </div>
                        <span class="text-sm text-gray-500">ID: {{ $case['id'] }}</span>
                    </div>
                </div>

                <div class="px-6 py-4">
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="text-sm font-medium text-gray-700">Court:</span>
                            <span class="text-sm text-gray-900 text-right">
                                🏛 {{ $case['court']['name'] }}
                            </span>
                        </div>

                        <div class="flex justify-between items-start">
                            <span class="text-sm font-medium text-gray-700">Parties:</span>
                            <div class="flex flex-wrap gap-2 max-w-[60%] justify-end">
                                @foreach(explode(',', $case['party_names']) as $name)
                                <span class="px-2.5 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs">
                                    {{ trim($name) }}
                                </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Contact:</span>
                            <a href="tel:{{ $case['mobile'] }}" class="text-sm text-blue-600 hover:text-blue-800">
                                📞 {{ $case['mobile'] }}
                            </a>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Opposing Lawyer:</span>
                            <span class="text-sm text-gray-900">⚖️ {{ $case['opposit_lawyer'] }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Next Hearing:</span>
                            <span class="text-sm text-gray-900">
                                📅 {{ \Carbon\Carbon::parse($case['upcoming_case_date'])->format('d M Y') }}
                                <span class="text-xs text-gray-500 ml-1">
                                    ({{ \Carbon\Carbon::parse($case['upcoming_case_date'])->diffForHumans() }})
                                </span>
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Status:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs 
                            {{ $case['status'] === 'closed' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ ucfirst($case['status']) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-2">Case Notes:</p>
                        <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $case['notes'] }}</p>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        Updated: {{ \Carbon\Carbon::parse($case['updated_at'])->format('d M Y H:i') }}
                    </p>
                </div>
            </div>

            <!-- Related Cases Card -->
            <div class="bg-white dark:bg-gray-800 dark:text-gray-100 rounded-lg shadow overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">Related Cases</h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Case Number</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($caseList as $entry)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $entry['case_number'] }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
                                        Type {{ $entry['case_type'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($entry['created_at'])->format('d M Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if(count($caseList) === 0)
                    <div class="p-6 text-center text-gray-400">
                        No related entries found
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-800">Case Timeline</h3>
            </div>
        </div>

        <div class="px-4 py-6">
            <div class="relative pl-6 timeline-container">
                <!-- Vertical line -->
                <div class="absolute left-0 top-4 h-full w-0.5 bg-gray-200 transform -translate-x-1/2 ml-3"></div>

                @foreach($followups as $followup)
                <div class="relative mb-8 timeline-item">
                    <!-- Timeline dot -->
                    <div class="absolute left-0 inline-flex items-center justify-center w-6 h-6 bg-blue-500 rounded-full text-white text-xs font-bold -translate-x-1/2">
                        {{ \Carbon\Carbon::parse($followup->next_hearing)->format('d') }}
                    </div>

                    <div class="ml-10">
                        <div class="p-4 bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-600">
                                        {{ \Carbon\Carbon::parse($followup->next_hearing)->format('M d, Y') }}
                                    </span>
                                    @if($followup->advocate_attended)
                                    <span class="flex items-center text-green-600 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                                        </svg>
                                        Attended
                                    </span>
                                    @else
                                    <span class="flex items-center text-red-600 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        Not Attended
                                    </span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($followup->created_at)->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm whitespace-pre-wrap">Attended By : {{ $followup->advocate->name }}</p>
                            <p class="text-gray-600 text-sm whitespace-pre-wrap">{{ $followup->notes }}</p>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- First line gradient fix -->
                <div class="absolute left-0 top-0 h-4 w-0.5 bg-gradient-to-b from-white to-gray-200 transform -translate-x-1/2 ml-3"></div>
                <!-- Last line gradient fix -->
                <div class="absolute left-0 bottom-0 h-4 w-0.5 bg-gradient-to-t from-white to-gray-200 transform -translate-x-1/2 ml-3"></div>
            </div>

            @if(count($followups) === 0)
            <div class="text-center py-6 text-gray-400">
                No timeline entries found
            </div>
            @endif
        </div>
    </div>
</div>