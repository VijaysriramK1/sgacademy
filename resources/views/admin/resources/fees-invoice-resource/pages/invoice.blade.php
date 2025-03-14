<x-filament-panels::page>
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
        <div class="flex justify-between items-start">

            <!-- Logo and "Invoice" header -->
            <div style="text-align: justify">
                <img src="{{asset('/logo/SG logo.png')}}" alt="SG" style="height: 100px;">
            </div>
            <div style="text-align: end;">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Invoice</h2>
                    <div class="text-sm mt-1">
                        <div class="text-blue-600 dark:text-blue-400">
                            Invoice no: {{ $invoice ? $invoice->invoice_id : 'N/A' }}
                        </div>
                        <div class="text-blue-600 dark:text-blue-400">Invoice date: {{ $invoice ? $invoice->create_date : 'N/A' }}</div>
                        <div class="text-blue-600 dark:text-blue-400">Due date: {{ $invoice ? $invoice->due_date : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>


        <!-- From/To section -->
        <div class="flex justify-between items-start">
            <!-- Left Side: From (Sender) -->
            <div style="text-align: justify">
                <h3 class="text-sm font-medium text-blue-400 dark:text-blue-400">From</h3>

                <div class="mt-2">
                    <h4 class="font-semibold text-blue-400 dark:text-blue-400">Mr/Ms: {{ $invoice ? $invoice->student->first_name : 'N/A' }} {{ $invoice ? $invoice->student->last_name : 'N/A' }}</h4>
                    <div class="text-sm mt-1 text-blue-400 dark:text-blue-400">
                        <p>{{ $invoice ? $invoice->student->current_address : 'N/A' }}</p>
                        <p>Email: {{ $invoice ? $invoice->student->email : 'N/A' }}</p>
                        <p>Phone: {{ $invoice ? $invoice->student->mobile : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: To (Recipient) -->
            <div style="text-align: end;">
                <h3 class="text-sm font-medium text-blue-400 dark:text-blue-400">Bill To</h3>
                <div class="mt-2">
                    <h4 class="font-semibold text-blue-400 dark:text-blue-400">Institutions Corp.</h4>
                    <div class="text-sm mt-1 text-blue-400 dark:text-blue-400">
                        <p>{{ $invoice ? $invoice->institution->address : 'N/A' }}</p>
                        <p>Email: {{ $invoice ? $invoice->institution->email : 'N/A' }}</p>
                        <p>Phone: {{ $invoice ? $invoice->institution->phone : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div><br><br>


        <!-- Invoice table -->
        <div class="mt-8">
            <table class="w-full border-collapse">
                <thead>
                    <tr style="background-color: cornflowerblue;color: white;font-family: auto;">
                        <th class="py-2 px-4 text-left uppercase font-semibold">Fees Type</th>
                        <th class="py-2 px-4 text-right uppercase font-semibold">Amount</th>
                        <th class="py-2 px-4 text-right uppercase font-semibold">Discount</th>
                        <th class="py-2 px-4 text-right uppercase font-semibold">Fine</th>
                        <th class="py-2 px-4 text-right uppercase font-semibold">Paid Amount</th>
                        <th class="py-2 px-4 text-right uppercase font-semibold">Scholarship Amount</th>
                        <th class="py-2 px-4 text-right uppercase font-semibold">Sub Total</th>
                    </tr>

                </thead>
                <tbody>
                    <tr class="border-b dark:border-gray-600">
                        <td class="py-2 px-4">
                            <div class="text-blue-400 dark:text-blue-400">{{ $invoice ? $invoice->feestype->name : 'N/A' }}</div>
                        </td>
                        <td class="py-2 px-4 text-right text-blue-400 dark:text-blue-400">
                            {{ $invoice ? $invoice->feesinvoice->sum('amount') : 'N/A' }}
                        </td>

                        <td class="py-2 px-4 text-right text-blue-400 dark:text-blue-400">{{ $invoice ? $invoice->feesinvoice->sum('discount') : 'N/A' }}</td>
                        <td class="py-2 px-4 text-right text-blue-400 dark:text-blue-400">{{ $invoice ? $invoice->feesinvoice->sum('fine') : 'N/A' }}</td>
                        <td class="py-2 px-4 text-right text-blue-400 dark:text-blue-400">{{ $invoice ? $invoice->feesinvoice->sum('paid_amount') : 'N/A' }}</td>
                        <td class="py-2 px-4 text-right text-blue-400 dark:text-blue-400">{{ $invoice ? $invoice->feesinvoice->sum('scholarship_amount') : 'N/A' }}</td>
                        <td class="py-2 px-4 text-right text-blue-400 dark:text-blue-400">{{ $invoice ? $invoice->feesinvoice->sum('sub_total') : 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div><br><br>

        <div class="flex justify-between items-start">
            <!-- Left Side: From (Sender) -->
            <div style="text-align: justify">
                <h3 class="text-sm font-medium text-blue-400 dark:text-blue-400">Payment Instruction</h3>
                <div class="text-sm mt-1 text-blue-400 dark:text-blue-400">
                    <div>Paypal: email</div>
                    <div>{{ $invoice ? $invoice->student->email : 'N/A' }}</div>
                    <div>Make checks payable to:</div>
                    <div>{{ $invoice ? $invoice->student->first_name : 'N/A' }} {{ $invoice ? $invoice->student->last_name : 'N/A' }}</div>
                    <div>Bank transfer:</div>
                    <div>Routing: XXXX-XXXXXXXX</div>
                </div>
            </div>

            <!-- Right Side: To (Recipient) -->
            <div style="text-align: end;">
                <!-- Subtotal Section -->

                <table class="text-right">
                    <tr class=" border-b dark:border-gray">
                        <td class="px-4 py-2" style="text-align: justify;">Subtotal:</td>
                        <td class="px-4 py-2">{{ $invoice ? $invoice->feesinvoice->sum('sub_total') : 'N/A' }}</td>
                    </tr>
                    <tr class=" border-b dark:border-gray">
                        <td class="px-4 py-2" style="text-align: justify;">Discount:</td>
                        <td class="px-4 py-2">{{ $invoice ? $invoice->feesinvoice->sum('discount') : 'N/A' }}</td>
                    </tr>
                    <tr class=" border-b dark:border-gray">
                        <td class="px-4 py-2" style="text-align: justify;">Fine:</td>
                        <td class="px-4 py-2">{{ $invoice ? $invoice->feesinvoice->sum('fine') : 'N/A' }}</td>
                    </tr>
                    <tr class=" border-b dark:border-gray">
                        <td class="px-4 py-2" style="text-align: justify;">Total Service Charge:</td>
                        <td class="px-4 py-2">{{ $invoice ? $invoice->feesinvoice->sum('service_charge') : 'N/A' }}</td>
                    </tr>
                    <tr class=" border-b dark:border-gray">
                        <td class="px-4 py-2"  style="text-align: justify;">Total Paid:</td>
                        <td class="px-4 py-2">{{ $invoice ? $invoice->feesinvoice->sum('paid_amount') : 'N/A' }}</td>
                    </tr>
                    <tr class=" border-b dark:border-gray">
                        <td class="px-4 py-2" style="text-align: justify;">Total Scholarship Amount:</td>
                        <td class="px-4 py-2">{{ $invoice ? $invoice->feesinvoice->sum('scholarship_amount') : 'N/A' }}</td>
                    </tr>
                    <tr class=" border-b dark:border-gray">
                        <td class="px-4 py-2" style="text-align: justify;">Grand Total:</td>
                        <td class="px-4 py-2">{{ $invoice ? $invoice->feesinvoice->sum('total') : 'N/A' }}</td>
                    </tr>
                    <tr class="bg-gray-200 border-b dark:border-gray">
                        <td class="px-4 py-2" style="text-align: justify;">Balance Due:</td>
                        <td class="px-4 py-2">{{ $invoice ? $invoice->feesinvoice->sum('due_amount') : 'N/A' }}</td>
                    </tr>
                </table>


            </div>
        </div><br><br>


        <!-- Notes -->


        <!-- Signature -->
        <div class="mt-8 flex justify-end">
            <img src="{{asset('/logo/SG logo.png')}}" alt="Signature" class="h-16" />
        </div>
    </div>
</x-filament-panels::page>