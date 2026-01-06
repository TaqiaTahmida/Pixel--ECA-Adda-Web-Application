@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col gap-2 mb-8">
        <p class="text-xs uppercase tracking-[0.3em] text-orange-400">Community</p>
        <h1 class="text-3xl font-semibold text-gray-900">Interaction Hub</h1>
        <p class="text-gray-600">Switch between live chat and achievements without losing your flow.</p>
    </div>

    <div class="bg-white border border-orange-100 rounded-2xl shadow-sm p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3" role="tablist" aria-label="Interaction hub tabs">
            <button
                type="button"
                role="tab"
                aria-selected="true"
                class="tab-button flex-1 sm:flex-none px-4 py-2 text-sm font-semibold rounded-full border transition focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 bg-orange-600 text-white border-orange-600 shadow-sm"
                data-tab-target="chat"
            >
                Chat
            </button>
            <button
                type="button"
                role="tab"
                aria-selected="false"
                class="tab-button flex-1 sm:flex-none px-4 py-2 text-sm font-semibold rounded-full border transition focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 bg-white text-orange-700 border-orange-200 hover:bg-orange-50"
                data-tab-target="achievements"
            >
                Achievements
            </button>
        </div>
    </div>

    <div class="mt-6">
        <section id="tab-chat" data-tab-panel="chat" role="tabpanel" class="space-y-4">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-5 py-4 border-b border-gray-100">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-gray-400">Group Chat</p>
                        <h2 class="text-lg font-semibold text-gray-900">Talk with your peers</h2>
                    </div>
                    <span class="text-xs text-gray-500">Last 50 messages</span>
                </div>
                <div class="max-h-[360px] overflow-y-auto px-5 py-4 space-y-4 bg-gradient-to-b from-orange-50/60 to-white">
                    @forelse($messages as $msg)
                        <div class="flex gap-3">
                            <div class="mt-1 flex h-9 w-9 items-center justify-center rounded-full bg-orange-100 text-orange-700 text-sm font-semibold">
                                {{ strtoupper(substr($msg->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold text-gray-900">{{ $msg->user->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $msg->created_at?->diffForHumans() }}</span>
                                </div>
                                <p class="mt-1 text-sm text-gray-700 bg-white border border-orange-100 rounded-xl px-3 py-2 shadow-sm">
                                    {{ $msg->message }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500">No messages yet. Start the conversation.</div>
                    @endforelse
                </div>
                <div class="border-t border-gray-100 px-5 py-4 bg-white">
                    <form method="POST" action="{{ route('dashboard.chat.send', ['tab' => 'chat']) }}">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input
                                type="text"
                                name="message"
                                class="flex-1 rounded-full border border-gray-200 px-4 py-2 text-sm focus:border-orange-400 focus:ring-orange-400"
                                placeholder="Type a message..."
                                maxlength="500"
                                required
                            >
                            <button type="submit" class="rounded-full bg-orange-600 px-5 py-2 text-sm font-semibold text-white hover:bg-orange-500 transition">
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section id="tab-achievements" data-tab-panel="achievements" role="tabpanel" class="space-y-4 hidden">
            @php
                $reactionEmojis = [
                    'like' => '👍',
                    'clap' => '👏',
                    'star' => '⭐',
                ];
            @endphp
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-gray-400">Achievements</p>
                        <h2 class="text-lg font-semibold text-gray-900">Share your wins</h2>
                        <p class="text-sm text-gray-500">Upload a milestone and collect reactions from the community.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('dashboard.achievements.upload', ['tab' => 'achievements']) }}" enctype="multipart/form-data" class="mt-4 grid gap-3 sm:grid-cols-2">
                    @csrf
                    <input
                        type="text"
                        name="title"
                        class="rounded-xl border border-gray-200 px-4 py-2 text-sm focus:border-orange-400 focus:ring-orange-400"
                        placeholder="Achievement title"
                        maxlength="255"
                        required
                    >
                    <input
                        type="file"
                        name="file"
                        class="rounded-xl border border-gray-200 px-4 py-2 text-sm"
                        accept=".jpg,.png,.pdf,.docx"
                    >
                    <textarea
                        name="description"
                        class="sm:col-span-2 rounded-xl border border-gray-200 px-4 py-2 text-sm focus:border-orange-400 focus:ring-orange-400"
                        rows="3"
                        placeholder="Add a short description"
                    ></textarea>
                    <div class="sm:col-span-2">
                        <button type="submit" class="rounded-full bg-orange-600 px-5 py-2 text-sm font-semibold text-white hover:bg-orange-500 transition">
                            Upload achievement
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-4">
                @forelse($achievements as $ach)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $ach->title }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $ach->description }}</p>
                                @if($ach->file_path)
                                    <a
                                        href="{{ asset('storage/'.$ach->file_path) }}"
                                        target="_blank"
                                        class="mt-2 inline-flex items-center gap-2 text-sm font-semibold text-orange-600 hover:text-orange-500"
                                    >
                                        View file
                                    </a>
                                @endif
                                <p class="mt-2 text-xs text-gray-500">Posted by {{ $ach->user->name }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $ach->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <form method="POST" action="{{ route('dashboard.achievements.react', ['id' => $ach->id, 'tab' => 'achievements']) }}" class="flex flex-wrap gap-2">
                                @csrf
                                <button type="submit" name="type" value="like" class="rounded-full border border-orange-200 px-4 py-1 text-xs font-semibold text-orange-700 hover:bg-orange-50 transition">
                                    👍
                                    <span class="sr-only">Like</span>
                                </button>
                                <button type="submit" name="type" value="clap" class="rounded-full border border-green-200 px-4 py-1 text-xs font-semibold text-green-700 hover:bg-green-50 transition">
                                    👏
                                    <span class="sr-only">Clap</span>
                                </button>
                                <button type="submit" name="type" value="star" class="rounded-full border border-yellow-200 px-4 py-1 text-xs font-semibold text-yellow-700 hover:bg-yellow-50 transition">
                                    ⭐
                                    <span class="sr-only">Star</span>
                                </button>
                            </form>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-2">
                            @forelse($ach->reactions as $reaction)
                                @php($emoji = $reactionEmojis[$reaction->type] ?? '💬')
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-600">
                                    {{ $emoji }} {{ $reaction->user->name }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-400">No reactions yet.</span>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-6 text-center text-sm text-gray-500">
                        No achievements yet. Upload the first one.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = Array.from(document.querySelectorAll('[data-tab-target]'));
        const panels = Array.from(document.querySelectorAll('[data-tab-panel]'));

        if (!tabs.length || !panels.length) {
            return;
        }

        const activeClasses = ['bg-orange-600', 'text-white', 'border-orange-600', 'shadow-sm'];
        const inactiveClasses = ['bg-white', 'text-orange-700', 'border-orange-200', 'hover:bg-orange-50'];

        const setButtonState = (button, isActive) => {
            const addClasses = isActive ? activeClasses : inactiveClasses;
            const removeClasses = isActive ? inactiveClasses : activeClasses;

            addClasses.forEach((className) => button.classList.add(className));
            removeClasses.forEach((className) => button.classList.remove(className));

            button.setAttribute('aria-selected', isActive ? 'true' : 'false');
            button.tabIndex = isActive ? 0 : -1;
        };

        const activateTab = (target) => {
            tabs.forEach((button) => setButtonState(button, button.dataset.tabTarget === target));
            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.tabPanel !== target);
            });
        };

        const params = new URLSearchParams(window.location.search);
        const queryTab = params.get('tab');
        const hashTab = window.location.hash.replace('#', '');
        const preferredTab = queryTab || hashTab;
        const defaultTab = tabs[0].dataset.tabTarget;
        const initialTab = tabs.some((button) => button.dataset.tabTarget === preferredTab) ? preferredTab : defaultTab;

        activateTab(initialTab);

        tabs.forEach((button) => {
            button.addEventListener('click', () => {
                const target = button.dataset.tabTarget;
                activateTab(target);
                const url = new URL(window.location.href);
                url.hash = target;
                history.replaceState(null, '', url);
            });
        });
    });
</script>
@endpush
