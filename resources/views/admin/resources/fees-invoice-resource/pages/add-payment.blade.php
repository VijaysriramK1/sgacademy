<x-filament-panels::page>
    <form action="{{ route('admin.resources.fees-invoices.add-payment.process', $record) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left Section: Student Details -->
            <section class="w-48 md:w-1/2">
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                    <div class="student-meta-box">
                        <div class="student-meta-top"></div>
                        <img class="student-meta-img img-100"
                            src="{{ $payment->student->student_photo ? Storage::url($payment->student->student_photo) : asset('logo/empty_profile.jpeg') }}"
                            alt="Student Photo"><br>

                        <div class="mt-4">
                            <div class="flex justify-between">
                                <div class="text-left font-semibold">Student Name:</div>
                                <div class="text-right">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</div>
                            </div>
                            <hr>
                            <div class="flex justify-between">
                                <div class="text-left font-semibold">Admission Number:</div>
                                <div class="text-right">{{ $payment->student->admission_no }}</div>
                            </div>
                            <hr>
                            <div class="flex justify-between">
                                <div class="text-left font-semibold">Roll Number:</div>
                                <div class="text-right">{{ $payment->student->roll_number ?? 'N/A' }}</div>
                            </div>
                            <hr>
                            <div class="flex justify-between">
                                <div class="text-left font-semibold">Batch:</div>
                                <div class="text-right">{{ $payment->batch->name ?? 'N/A' }}</div>
                            </div>
                            <hr>
                            <div class="flex justify-between">
                                <div class="text-left font-semibold">Program:</div>
                                <div class="text-right">{{ $payment->program->name ?? 'N/A' }}</div>
                            </div>
                            <hr><br>

                            <select id="payment_method" name="payment_method" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Payment Method</option>
                                <option value="cheque">Cheque</option>
                                <option value="cash">Cash</option>
                            </select>
                            @error('payment_method')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <br>

                            <!-- Note Input & File Upload (Hidden by Default) -->
                            <div id="cheque_fields" class="mt-3 hidden w-full max-w-lg">
                                <!-- Cheque Note -->
                                <label for="cheque_note" class="block text-sm font-medium text-blue-400 dark:text-blue-400">Cheque Note</label>
                                <textarea id="cheque_note" name="cheque_note" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full max-w-lg p-2.5 mt-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Enter cheque details" style="margin-top: 5px;">{{ old('cheque_note') }}</textarea>
                                @error('cheque_note')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <br>

                                <!-- Upload Cheque File -->
                                <label for="cheque_file" class="block mt-2 text-sm font-medium text-blue-400 dark:text-blue-400">Upload Cheque File</label>
                                <input type="file" name="cheque_file" id="cheque_file" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full max-w-lg p-2.5 mt-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" style="margin-top: 5px;">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                                @error('cheque_file')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div><br>

                            <button type="submit" class="mt-4 w-full text-white bg-blue-700 !bg-blue-700 hover:!bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all duration-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" style="background-color: orange;">
                                ADD PAYMENT
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Right Section: Payment Details -->
            <section class="w-full md:w-1/2">
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                    <table class="w-full border border-gray-300 rounded-lg shadow-sm" style="border: none;">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase">
                            <tr style="border: none;">
                                <th class="border px-4 py-2" style="border: none;">SL</th>
                                <th class="border px-4 py-2" style="border: none;">Fees Type</th>
                                <th class="border px-4 py-2" style="border: none;">Amount</th>
                                <th class="border px-4 py-2" style="border: none;">Due</th>
                                <th class="border px-4 py-2" style="border: none;">Paid Amount</th>
                                <th class="border px-4 py-2" style="border: none;">Discount</th>
                                <th class="border px-4 py-2" style="border: none;">Fine</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border: none;">
                                <td class="border px-4 py-2" style="border: none;">1</td>
                                <td class="px-4 py-2 border-0">
                                    {{$payment->feestype->type}}({{$payment->feestype->name}})
                                </td>
                                <td class="border px-4 py-2" style="border: none;">{{$payment->feesinvoice->sum('amount')}}</td>
                                <td class="border px-4 py-2" style="border: none;">
                                    <span id="dueAmount">
                                        {{ $payment->feesinvoice->sum('due_amount') ?? 0 }}
                                    </span>
                                    <input type="hidden" name="due_amount" value="{{ $payment->feesinvoice->sum('due_amount') ?? 0 }}">
                                </td>


                                <td class="border px-4 py-2 border-0" style="border: none; width: 150px;">
                                    <input type="number" id="paid_amount" name="paid_amount" value="{{ old('paid_amount', 0) }}" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:border-blue-500 focus:ring-0">
                                    @error('paid_amount')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="border px-4 py-2 border-0" style="border: none; width: 150px;">
                                    <input type="number" id="discount" name="discount" value="{{ old('discount', 0) }}" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:border-blue-500 focus:ring-0">
                                    @error('discount')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="border px-4 py-2 border-0" style="border: none; width: 150px;">
                                    <input type="number" id="fine" name="fine" value="{{ old('fine', 0) }}" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:border-blue-500 focus:ring-0">
                                    @error('fine')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let dueAmountElement = document.getElementById("dueAmount");
            let originalDueAmount = parseFloat(dueAmountElement.innerText) || 0;

            let paidAmountInput = document.getElementById("paid_amount");
            let discountInput = document.getElementById("discount");
            let fineInput = document.getElementById("fine");

            function updateDueAmount() {
                let paidAmount = parseFloat(paidAmountInput.value) || 0;
                let discount = parseFloat(discountInput.value) || 0;
                let fine = parseFloat(fineInput.value) || 0;

                let newDueAmount = (originalDueAmount - paidAmount - discount) + fine;
                dueAmountElement.innerText = newDueAmount.toFixed(2);
            }

            paidAmountInput.addEventListener("input", updateDueAmount);
            discountInput.addEventListener("input", updateDueAmount);
            fineInput.addEventListener("input", updateDueAmount);
        });
    </script>
    <script>
        document.getElementById("payment_method").addEventListener("change", function() {
            let chequeFields = document.getElementById("cheque_fields");
            if (this.value === "cheque") {
                chequeFields.classList.remove("hidden"); // Show note & file input
            } else {
                chequeFields.classList.add("hidden"); // Hide if not cheque
            }
        });


        document.addEventListener("DOMContentLoaded", function () {
    let dueAmountSpan = document.getElementById("dueAmount");
    let dueAmountInput = document.querySelector("input[name='due_amount']");

    function updateDueAmount(newAmount) {
        dueAmountSpan.textContent = newAmount;
        dueAmountInput.value = newAmount;
    }

    // Example: Update when payment is made
    document.getElementById("paymentButton").addEventListener("click", function () {
        let newDueAmount = calculateNewDueAmount(); // Define how you calculate it
        updateDueAmount(newDueAmount);
    });
});

    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let inputFields = document.querySelectorAll("input[type='number']");
            let paymentMethod = document.getElementById("payment_method");

            inputFields.forEach(input => {
                input.disabled = true;
            });

            paymentMethod.addEventListener("change", function() {
                if (this.value) {
                    inputFields.forEach(input => {
                        input.disabled = false;
                    });

                    window.filamentNotify('success', 'Payment method selected, you can proceed.');
                }
            });
        });
    </script>
</x-filament-panels::page>