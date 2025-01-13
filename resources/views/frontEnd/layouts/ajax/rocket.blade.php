<div class="payment-rule">
    <h5>রকেট পেমেন্ট করতে নিচের নিয়মটি অনুসরণ করুন</h5>
    <ul>
        <li>
            1. ডায়াল মেনু থেকে *322# ডায়াল করুন, অথবা রকেট অ্যাপে যান।
        </li>
        <li>
            2. "ক্যাশ আউট" এ ক্লিক করুন।
        </li>
        <li>
            3. প্রাপকের নম্বর হিসাবে এই নম্বরটি লিখুন: 01302029990
        </li>
        <li>
            4. টাকা পরিমাণ লিখুন ।
        </li>
        <li>
            5. নিশ্চিত করতে আপনার পিন লিখুন।
        </li>
        <li>
            6. নিচের বক্সে আপনার লেনদেন আইডি এবং যে নম্বর থেকে আপনি টাকা পাঠিয়েছেন
            সেটি লিখুন।
        </li>
        <li>
            7. "CONFIRM" বোতামে ক্লিক করুন৷
        </li>
        <li>

        </li>
    </ul>
</div>
<div class="common-payment-rule">
    <div class="form-group mb-3">
        <label for="sender_number">Sender Number</label>
        <input type="number" id="sender_number" class="form-control @error('sender_number') is-invalid @enderror"
            name="sender_number" value="{{ old('sender_number') }}" required>
        @error('sender_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <!-- col-end -->
    <div class="form-group mb-3">
        <label for="transaction">Transaction ID</label>
        <input type="text" id="transaction" class="form-control @error('transaction') is-invalid @enderror"
            name="transaction" value="{{ old('transaction') }}">
        @error('transaction')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <!-- col-end -->
</div>