@extends('layouts.admin')
@section('title', isset($article) ? 'Edit Artikel' : 'Tulis Artikel')
@section('page-title', isset($article) ? 'Edit Artikel' : 'Tulis Artikel Baru')
@section('content')
@php
    $a = $article ?? null;
    $locales = $locales ?? ['id', 'en', 'ar', 'ko'];
    $localeLabels = [
        'id' => 'Indonesia',
        'en' => 'English',
        'ar' => 'العربية',
        'ko' => '한국어',
    ];
    $activeLang = old('_active_lang', 'id');

    // For edit: get translation data per locale
    $trans = [];
    if ($a) {
        foreach ($locales as $lc) {
            $trans[$lc] = $translations[$lc] ?? null;
        }
    }
@endphp

<style>
/* ===== Premium Form Styles ===== */
.premium-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    border: 1px solid #E2E8F0;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
}
.premium-card-header {
    font-size: 0.85rem;
    font-weight: 700;
    color: #1E293B;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin: 0 0 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.form-group { margin-bottom: 1.25rem; }
.form-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
}
.form-label span.req { color: #EF4444; }
.form-label span.hint { font-weight: 400; color: #94A3B8; font-size: 0.75rem; margin-left: 0.25rem; }
.form-input, .form-select, .form-textarea {
    width: 100%;
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    color: #1E293B;
    background: #F8FAFC;
    transition: all 0.2s;
    outline: none;
    font-family: inherit;
    box-sizing: border-box;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: #3B82F6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
}
.form-textarea { resize: vertical; min-height: 80px; }
.char-count { font-size: 0.75rem; color: #94A3B8; margin-top: 0.35rem; text-align: right; }

/* ===== Language Tab Switcher ===== */
.lang-tabs {
    display: flex;
    gap: 0.35rem;
    background: #F1F5F9;
    border-radius: 12px;
    padding: 0.35rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}
.lang-tab {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    border: none;
    background: transparent;
    font-size: 0.82rem;
    font-weight: 600;
    color: #64748B;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
    white-space: nowrap;
}
.lang-tab:hover { background: #fff; color: #1E293B; }
.lang-tab.active {
    background: #fff;
    color: #3B82F6;
    box-shadow: 0 2px 8px rgba(59,130,246,0.12);
}
.lang-tab .lang-badge {
    font-size: 0.7rem;
    padding: 0.1rem 0.4rem;
    border-radius: 4px;
    background: #E2E8F0;
    color: #64748B;
    font-weight: 700;
}
.lang-tab.active .lang-badge { background: #DBEAFE; color: #3B82F6; }
.lang-tab .complete-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #CBD5E1;
    display: inline-block;
    margin-left: 2px;
}
.lang-tab .complete-dot.filled { background: #22C55E; }

/* Language panel */
.lang-panel { display: none; }
.lang-panel.active { display: block; }

/* RTL hint */
.rtl-hint {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.75rem;
    color: #7C3AED;
    background: #F5F3FF;
    border: 1px solid #DDD6FE;
    border-radius: 6px;
    padding: 0.25rem 0.6rem;
    margin-bottom: 0.75rem;
}

/* Editor Styles */
.editor-toolbar {
    background: #F8FAFC;
    border: 1.5px solid #E2E8F0;
    border-radius: 12px 12px 0 0;
    border-bottom: none;
    padding: 0.75rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
}
.editor-btn {
    padding: 0.35rem 0.6rem;
    background: #fff;
    border: 1px solid #E2E8F0;
    color: #475569;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}
.editor-btn:hover { background: #F1F5F9; color: #1E293B; border-color: #CBD5E1; }
.editor-btn.active { background: #3B82F6; color: #fff; border-color: #3B82F6; }
.editor-divider { width: 1px; background: #E2E8F0; margin: 0 0.25rem; }
.editor-area {
    border: 1.5px solid #E2E8F0;
    border-radius: 0 0 12px 12px;
    min-height: 380px;
    padding: 1.5rem;
    font-size: 1rem;
    line-height: 1.8;
    color: #1E293B;
    background: #fff;
    outline: none;
}
.editor-area:focus { border-color: #3B82F6; }
.editor-area[dir="rtl"] { font-family: 'Amiri', 'Segoe UI', serif; }

/* Switch */
.switch-label { display: flex; align-items: center; gap: 0.75rem; cursor: pointer; }
.switch-input { width: 20px; height: 20px; accent-color: #3B82F6; cursor: pointer; }
.switch-text { font-size: 0.9rem; font-weight: 600; color: #334155; }

/* Buttons */
.btn-primary-new {
    background: #3B82F6; color: #fff; border: none; padding: 0.875rem 1.5rem;
    border-radius: 12px; font-weight: 700; font-size: 0.9rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    transition: all 0.2s; box-shadow: 0 4px 14px rgba(59,130,246,0.3); width: 100%;
}
.btn-primary-new:hover { background: #2563EB; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(59,130,246,0.4); }
.btn-outline-new {
    background: #fff; color: #64748B; border: 1.5px solid #E2E8F0; padding: 0.875rem 1.5rem;
    border-radius: 12px; font-weight: 600; font-size: 0.9rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    transition: all 0.2s; width: 100%; text-decoration: none;
}
.btn-outline-new:hover { background: #F8FAFC; color: #1E293B; border-color: #CBD5E1; }

.img-preview {
    width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 8px;
    margin-bottom: 0.75rem; border: 1px solid #E2E8F0;
}

/* Translation completeness bar */
.trans-progress {
    display: flex;
    gap: 0.35rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}
.trans-progress-item {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.2rem 0.55rem;
    border-radius: 5px;
    background: #F1F5F9;
    color: #94A3B8;
    border: 1px solid #E2E8F0;
}
.trans-progress-item.done { background: #DCFCE7; color: #16A34A; border-color: #BBF7D0; }
</style>

<div style="max-width:1080px; margin:0 auto;">
    {{-- PAGE HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
        <div>
            <h1 style="font-size:1.5rem;font-weight:800;color:#1E293B;margin:0 0 .25rem;letter-spacing:-.02em;">{{ $a ? 'Edit Artikel' : 'Tulis Artikel Baru' }}</h1>
            <p style="font-size:.875rem;color:#94A3B8;margin:0;">Isi konten dalam berbagai bahasa menggunakan tab di bawah.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="btn-outline-new" style="width:auto;padding:.5rem 1rem;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ $a ? route('admin.articles.update',$a) : route('admin.articles.store') }}" enctype="multipart/form-data" id="article-form">
    @csrf @if($a) @method('PUT') @endif
    {{-- Track active lang for repopulate after validation error --}}
    <input type="hidden" name="_active_lang" id="active-lang-input" value="{{ $activeLang }}">

    <div style="display:grid;grid-template-columns:minmax(0, 1fr) 340px;gap:1.5rem;">

        {{-- LEFT COLUMN --}}
        <div>

            {{-- LANGUAGE TAB SWITCHER --}}
            <div class="premium-card" style="padding:1.25rem 1.5rem 0.5rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <h3 class="premium-card-header" style="margin:0;border:none;padding:0;">Konten Per Bahasa</h3>
                    {{-- Translation completeness badges --}}
                    <div class="trans-progress" id="trans-progress-bar"></div>
                </div>

                {{-- Tabs --}}
                <div class="lang-tabs" id="lang-tabs">
                    @foreach($locales as $lc)
                    <button type="button" class="lang-tab {{ $lc === $activeLang ? 'active' : '' }}"
                        id="tab-{{ $lc }}"
                        onclick="switchLang('{{ $lc }}')"
                        data-locale="{{ $lc }}">
                        {{ $localeLabels[$lc] }}
                        <span class="lang-badge">{{ strtoupper($lc) }}</span>
                        <span class="complete-dot {{ ($a && $trans[$lc]?->is_complete) ? 'filled' : '' }}" id="dot-{{ $lc }}"></span>
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- LANGUAGE PANELS --}}
            @foreach($locales as $lc)
            @php
                $isRTL = ($lc === 'ar');
                $t = $trans[$lc] ?? null;
                $ctaText = old("translations.{$lc}.cta_text", $t?->cta_button['text'] ?? '');
                $ctaUrl  = old("translations.{$lc}.cta_url", $t?->cta_button['url'] ?? '');
                $ctaType = old("translations.{$lc}.cta_type", $t?->cta_button['type'] ?? 'wa');
                $faqs    = old("translations.{$lc}.faqs", $t?->faqs ?? []);
                $titlePlaceholder = ['id'=>'Cara Memilih Alat Rumah yang Tepat...','en'=>'How to Choose the Right Alat Rumah...','ar'=>'كيف تختار المروحة المناسبة...','ko'=>'올바른 환풍기 선택 방법...'];
            @endphp

            <div class="lang-panel {{ $lc === $activeLang ? 'active' : '' }}" id="panel-{{ $lc }}" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">

                {{-- RTL hint --}}
                @if($isRTL)
                <div class="rtl-hint">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    الكتابة من اليمين إلى اليسار — RTL Mode Active
                </div>
                @endif

                {{-- Konten Utama --}}
                <div class="premium-card">
                    <h3 class="premium-card-header">
                        {{ $localeLabels[$lc] }} — Konten Utama
                        @if($lc === 'id') <span style="color:#EF4444;font-size:.75rem;">Wajib diisi</span> @endif
                    </h3>

                    <div class="form-group">
                        <label class="form-label">
                            Judul Artikel
                            @if($lc === 'id') <span class="req">*</span> @endif
                        </label>
                        <input type="text"
                            name="translations[{{ $lc }}][title]"
                            id="art-title-{{ $lc }}"
                            value="{{ old("translations.{$lc}.title", $t?->title) }}"
                            class="form-input"
                            {{ $lc === 'id' ? 'required' : '' }}
                            {{ $isRTL ? 'dir=rtl' : '' }}
                            oninput="{{ $lc === 'id' ? 'autoSlug()' : '' }}"
                            placeholder="{{ $titlePlaceholder[$lc] }}">
                    </div>

                    @if($lc === 'id')
                    <div class="form-group">
                        <label class="form-label">Slug (URL) <span class="hint">Otomatis dari judul jika dikosongkan.</span></label>
                        <div style="display:flex;align-items:center;background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:10px;padding:0 1rem;overflow:hidden;">
                            <span style="font-size:.85rem;color:#94A3B8;white-space:nowrap;">/articles/</span>
                            <input type="text" name="slug" id="art-slug" value="{{ old('slug',$a?->slug) }}" style="border:none;background:transparent;padding:0.75rem 0;width:100%;font-size:.9rem;color:#1E293B;outline:none;" pattern="[a-z0-9\-]*" placeholder="auto-dari-judul">
                        </div>
                    </div>
                    @endif

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Excerpt / Ringkasan <span class="hint">(max 500)</span></label>
                        <textarea name="translations[{{ $lc }}][excerpt]" class="form-textarea" rows="2" maxlength="500"
                            {{ $isRTL ? 'dir=rtl' : '' }}
                            oninput="document.getElementById('exc-cnt-{{ $lc }}').textContent=this.value.length"
                            placeholder="Tuliskan ringkasan singkat...">{{ old("translations.{$lc}.excerpt", $t?->excerpt) }}</textarea>
                        <div class="char-count"><span id="exc-cnt-{{ $lc }}">{{ strlen(old("translations.{$lc}.excerpt", $t?->excerpt ?? '')) }}</span>/500</div>
                    </div>
                </div>

                {{-- Editor Konten --}}
                <div class="premium-card" style="padding:0;overflow:hidden;border:none;">
                    <h3 class="premium-card-header" style="padding:1.25rem 1.5rem;margin:0;border:1px solid #E2E8F0;border-bottom:none;border-radius:12px 12px 0 0;">
                        Isi Artikel @if($lc === 'id') <span class="req" style="margin-left:4px;">*</span> @endif
                    </h3>

                    <div class="editor-toolbar" id="toolbar-{{ $lc }}">
                        <button type="button" class="editor-btn" onclick="fmt('bold','{{ $lc }}')" style="font-weight:800;">B</button>
                        <button type="button" class="editor-btn" onclick="fmt('italic','{{ $lc }}')" style="font-style:italic;">I</button>
                        <button type="button" class="editor-btn" onclick="fmt('underline','{{ $lc }}')" style="text-decoration:underline;">U</button>
                        <div class="editor-divider"></div>
                        <button type="button" class="editor-btn" onclick="fmtBlock('h2','{{ $lc }}')">H2</button>
                        <button type="button" class="editor-btn" onclick="fmtBlock('h3','{{ $lc }}')">H3</button>
                        <button type="button" class="editor-btn" onclick="fmtBlock('p','{{ $lc }}')">P</button>
                        <div class="editor-divider"></div>
                        <button type="button" class="editor-btn" onclick="fmt('insertUnorderedList','{{ $lc }}')">UL</button>
                        <button type="button" class="editor-btn" onclick="fmt('insertOrderedList','{{ $lc }}')">OL</button>
                        <div class="editor-divider"></div>
                        <button type="button" class="editor-btn" onclick="insertLink('{{ $lc }}')">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                        </button>
                        <button type="button" class="editor-btn" onclick="insertEditorImage('{{ $lc }}')">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </button>
                        <button type="button" class="editor-btn" onclick="insertQuote('{{ $lc }}')">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z"/></svg>
                        </button>
                        <button type="button" class="editor-btn" onclick="insertCode('{{ $lc }}')" style="font-family:monospace;">&lt;/&gt;</button>
                        <div style="flex-grow:1;"></div>
                        <button type="button" class="editor-btn" id="html-btn-{{ $lc }}" onclick="toggleHtml('{{ $lc }}')" style="color:#64748B;">HTML</button>
                    </div>

                    <div id="editor-{{ $lc }}" class="editor-area" contenteditable="true"
                        dir="{{ $isRTL ? 'rtl' : 'ltr' }}"
                        oninput="syncContent('{{ $lc }}')">{!! old("translations.{$lc}.content", $t?->content) !!}</div>
                    <textarea id="html-editor-{{ $lc }}" name="translations[{{ $lc }}][content]"
                        style="display:none;width:100%;min-height:380px;padding:1.5rem;color:#1E293B;font-size:.85rem;line-height:1.6;font-family:'Fira Code',monospace;background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:0 0 12px 12px;outline:none;resize:vertical;box-sizing:border-box;"
                        dir="{{ $isRTL ? 'rtl' : 'ltr' }}"
                        {{ $lc === 'id' ? 'required' : '' }}>{{ old("translations.{$lc}.content", $t?->content) }}</textarea>
                </div>

                {{-- FAQ --}}
                <div class="premium-card">
                    <div class="premium-card-header" style="margin-bottom:1rem;border:none;padding:0;">
                        <h3 style="margin:0;font-size:0.85rem;color:inherit;">FAQ — {{ $localeLabels[$lc] }}</h3>
                        <button type="button" onclick="addFaq('{{ $lc }}')" class="editor-btn" style="color:#3B82F6;border-color:rgba(59,130,246,0.2);background:rgba(59,130,246,0.05);">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah FAQ
                        </button>
                    </div>
                    <p style="font-size:.8rem;color:#64748B;margin-bottom:1.25rem;line-height:1.5;">Pertanyaan & jawaban otomatis generate Schema FAQPage.</p>
                    <div id="faq-list-{{ $lc }}" style="display:flex;flex-direction:column;gap:1rem;">
                        @foreach($faqs as $fi => $faq)
                        <div class="faq-item" style="background:#F8FAFC;border:1px solid #E2E8F0;padding:1.25rem;border-radius:12px;position:relative;" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">
                            <button type="button" onclick="this.closest('.faq-item').remove()" style="position:absolute;top:1rem;{{ $isRTL ? 'left' : 'right' }}:1rem;background:none;border:none;color:#94A3B8;cursor:pointer;padding:0;">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                            <input type="text" name="translations[{{ $lc }}][faqs][{{ $fi }}][q]" value="{{ $faq['q'] ?? '' }}" class="form-input" placeholder="{{ $isRTL ? 'سؤال...' : 'Pertanyaan...' }}" style="margin-bottom:.75rem;background:#fff;" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">
                            <textarea name="translations[{{ $lc }}][faqs][{{ $fi }}][a]" class="form-textarea" rows="2" placeholder="{{ $isRTL ? 'إجابة...' : 'Jawaban...' }}" style="background:#fff;" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">{{ $faq['a'] ?? '' }}</textarea>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- CTA --}}
                <div class="premium-card">
                    <h3 class="premium-card-header">CTA Button — {{ $localeLabels[$lc] }}</h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                        <div>
                            <label class="form-label">Teks Tombol</label>
                            <input type="text" name="translations[{{ $lc }}][cta_text]" value="{{ $ctaText }}" class="form-input" placeholder="cth: Konsultasi Gratis" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">
                        </div>
                        <div>
                            <label class="form-label">Tipe</label>
                            <select name="translations[{{ $lc }}][cta_type]" class="form-select">
                                <option value="wa" {{ $ctaType === 'wa' ? 'selected' : '' }}>WhatsApp (Otomatis)</option>
                                <option value="url" {{ $ctaType === 'url' ? 'selected' : '' }}>URL Custom</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">URL <span class="hint">(jika tipe URL Custom)</span></label>
                        <input type="text" name="translations[{{ $lc }}][cta_url]" value="{{ $ctaUrl }}" class="form-input" placeholder="https://...">
                    </div>
                </div>

                {{-- SEO --}}
                <div class="premium-card">
                    <h3 class="premium-card-header">SEO — {{ $localeLabels[$lc] }}</h3>
                    <div class="form-group">
                        <label class="form-label">Meta Title <span class="hint">(max 70)</span></label>
                        <input type="text" name="translations[{{ $lc }}][meta_title]"
                            value="{{ old("translations.{$lc}.meta_title", $t?->meta_title) }}"
                            class="form-input" maxlength="70"
                            dir="{{ $isRTL ? 'rtl' : 'ltr' }}"
                            oninput="document.getElementById('mt-cnt-{{ $lc }}').textContent=this.value.length">
                        <div class="char-count"><span id="mt-cnt-{{ $lc }}">{{ strlen(old("translations.{$lc}.meta_title", $t?->meta_title ?? '')) }}</span>/70</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Meta Description <span class="hint">(max 160)</span></label>
                        <textarea name="translations[{{ $lc }}][meta_desc]" class="form-textarea" rows="2" maxlength="160"
                            dir="{{ $isRTL ? 'rtl' : 'ltr' }}"
                            oninput="document.getElementById('md-cnt-{{ $lc }}').textContent=this.value.length">{{ old("translations.{$lc}.meta_desc", $t?->meta_desc) }}</textarea>
                        <div class="char-count"><span id="md-cnt-{{ $lc }}">{{ strlen(old("translations.{$lc}.meta_desc", $t?->meta_desc ?? '')) }}</span>/160</div>
                    </div>
                    <div class="form-group" style="margin-bottom:1.25rem;">
                        <label class="form-label">Meta Keywords <span class="hint">(pisah dengan koma)</span></label>
                        <input type="text" name="translations[{{ $lc }}][meta_keywords]"
                            value="{{ old("translations.{$lc}.meta_keywords", $t?->meta_keywords) }}"
                            class="form-input" placeholder="alat rumah atap, sirkulasi udara" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">
                    </div>
                    <div class="form-group" style="margin-bottom:1.25rem;">
                        <label class="form-label">Featured Snippet Target <span class="hint">(opsional, max 60 kata / 500 char)</span></label>
                        <textarea name="translations[{{ $lc }}][featured_snippet]" class="form-textarea" rows="2" maxlength="1000"
                            placeholder="Tuliskan 1 paragraf jawaban langsung untuk AI Search (Google SGE / ChatGPT)..."
                            dir="{{ $isRTL ? 'rtl' : 'ltr' }}">{{ old("translations.{$lc}.featured_snippet", $t?->featured_snippet) }}</textarea>
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Alt Text Gambar Utama <span class="hint">(untuk aksesibilitas & SEO gambar)</span></label>
                        <input type="text" name="translations[{{ $lc }}][thumbnail_alt]"
                            value="{{ old("translations.{$lc}.thumbnail_alt", $t?->thumbnail_alt) }}"
                            class="form-input" placeholder="Contoh: Pemasangan Alat Rumah di Atap Pabrik" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">
                    </div>
                </div>

            </div>{{-- /lang-panel --}}
            @endforeach

        </div>{{-- /LEFT COLUMN --}}

        {{-- RIGHT COLUMN --}}
        <div>

            {{-- Publish Card --}}
            <div class="premium-card">
                <h3 class="premium-card-header">Status Publikasi</h3>

                <div class="form-group">
                    <label class="switch-label">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published',$a?->is_published) ? 'checked' : '' }} class="switch-input">
                        <span class="switch-text">Publish Sekarang</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Publish</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $a?->published_at?->format('Y-m-d\TH:i')) }}" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Penulis</label>
                    <select name="author_id" class="form-select" style="background:#fff;">
                        <option value="">Tim Alat Rumah (Bawaan)</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id', $a?->author_id) == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="category" value="{{ old('category',$a?->category) }}" class="form-input" placeholder="Tips &amp; Panduan">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Tags <span class="hint">(pisah dengan koma)</span></label>
                    <input type="text" name="tags" value="{{ old('tags', $a && $a->tags ? implode(', ',$a->tags) : '') }}" class="form-input" placeholder="crane, hoist, instalasi">
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="premium-card">
                <h3 class="premium-card-header">Gambar Utama <span class="hint" style="text-transform:none;font-weight:400;margin-left:auto;">16:9 disarankan</span></h3>
                @if($a?->getRawOriginal('image'))
                    <img src="{{ asset('storage/'.$a->getRawOriginal('image')) }}" id="img-prev" class="img-preview">
                @else
                    <img id="img-prev" class="img-preview" style="display:none;">
                @endif
                <div style="position:relative;">
                    <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.6rem;background:#fff;" onchange="previewImg(this,'img-prev')">
                </div>
                <p style="font-size:.75rem;color:#94A3B8;margin:.75rem 0 0;line-height:1.5;">Otomatis diubah menjadi WebP. Berlaku untuk semua bahasa.</p>
            </div>

            {{-- OG Image --}}
            <div class="premium-card">
                <h3 class="premium-card-header">OG Image <span class="hint" style="text-transform:none;font-weight:400;margin-left:auto;">Opsional (1200×630)</span></h3>
                @if($a?->getRawOriginal('og_image'))
                    <img src="{{ asset('storage/'.$a->getRawOriginal('og_image')) }}" id="og-prev" class="img-preview">
                @else
                    <img id="og-prev" class="img-preview" style="display:none;">
                @endif
                <input type="file" name="og_image" accept="image/*" class="form-input" style="padding:0.6rem;background:#fff;" onchange="previewImg(this,'og-prev')">
            </div>

            {{-- Options --}}
            <div class="premium-card">
                <h3 class="premium-card-header">Opsi Lainnya</h3>
                <label class="switch-label">
                    <input type="hidden" name="show_toc" value="0">
                    <input type="checkbox" name="show_toc" value="1" {{ old('show_toc',$a?->show_toc) ? 'checked' : '' }} class="switch-input">
                    <span class="switch-text" style="font-size:.85rem;">Tampilkan Table of Contents (Daftar Isi otomatis dari H2/H3)</span>
                </label>
            </div>

            {{-- Action Buttons --}}
            <div style="display:flex;flex-direction:column;gap:0.75rem;position:sticky;top:6rem;">
                <button type="submit" class="btn-primary-new">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    {{ $a ? 'Simpan Perubahan' : 'Publish Artikel' }}
                </button>
                <a href="{{ route('admin.articles.index') }}" class="btn-outline-new">Batalkan</a>
            </div>

        </div>{{-- /RIGHT COLUMN --}}

    </div>
    </form>
</div>

@push('scripts')
<script>
const LOCALES = @json($locales);

// ===== Language Switching =====
function switchLang(locale) {
    LOCALES.forEach(lc => {
        document.getElementById('panel-' + lc).classList.toggle('active', lc === locale);
        document.getElementById('tab-' + lc).classList.toggle('active', lc === locale);
    });
    document.getElementById('active-lang-input').value = locale;
}

// ===== Editor per locale =====
const htmlModes = {};
LOCALES.forEach(lc => { htmlModes[lc] = false; });

function fmt(cmd, lc) {
    const ed = document.getElementById('editor-' + lc);
    ed.focus();
    document.execCommand(cmd, false, null);
}
function fmtBlock(tag, lc) {
    const ed = document.getElementById('editor-' + lc);
    ed.focus();
    document.execCommand('formatBlock', false, tag);
}
function syncContent(lc) {
    document.getElementById('html-editor-' + lc).value = document.getElementById('editor-' + lc).innerHTML;
}
function insertLink(lc) {
    const url = prompt('URL (https://...):'); if (!url) return;
    const text = prompt('Teks link:') || url;
    document.getElementById('editor-' + lc).focus();
    document.execCommand('insertHTML', false, `<a href="${url}" target="_blank" rel="noopener" style="color:#3B82F6;text-decoration:underline;">${text}</a>`);
    syncContent(lc);
}
function insertEditorImage(lc) {
    const input = document.createElement('input');
    input.type = 'file'; input.accept = 'image/*';
    input.onchange = function(e) {
        const file = e.target.files[0]; if (!file) return;
        const loadingId = 'img-loading-' + Date.now();
        const ed = document.getElementById('editor-' + lc);
        ed.focus();
        document.execCommand('insertHTML', false, `<span id="${loadingId}" style="color:#3B82F6;font-style:italic;">[Mengupload gambar...]</span>`);
        const fd = new FormData();
        fd.append('image', file);
        fd.append('_token', '{{ csrf_token() }}');
        fetch('{{ route("admin.upload.image") }}', { method: 'POST', body: fd })
            .then(r => r.json()).then(data => {
                const el = document.getElementById(loadingId);
                if (data.url) {
                    const html = `<img src="${data.url}" style="max-width:100%;border-radius:10px;margin:1.5rem 0;box-shadow:0 4px 20px rgba(0,0,0,0.05);">`;
                    if (el) el.outerHTML = html; else document.execCommand('insertHTML', false, html);
                } else if (el) el.outerHTML = `<span style="color:#EF4444;">[Gagal upload]</span>`;
                syncContent(lc);
            }).catch(() => {
                const el = document.getElementById(loadingId);
                if (el) el.outerHTML = `<span style="color:#EF4444;">[Error upload]</span>`;
            });
    };
    input.click();
}
function insertQuote(lc) {
    const sel = window.getSelection().toString() || 'Kutipan di sini...';
    document.getElementById('editor-' + lc).focus();
    document.execCommand('insertHTML', false, `<blockquote style="border-left:4px solid #3B82F6;padding-left:1rem;color:#475569;font-style:italic;margin:1.5rem 0;background:#F8FAFC;padding:1rem;">${sel}</blockquote>`);
    syncContent(lc);
}
function insertCode(lc) {
    const sel = window.getSelection().toString() || 'code';
    document.getElementById('editor-' + lc).focus();
    document.execCommand('insertHTML', false, `<code style="background:#F1F5F9;padding:0.2rem 0.4rem;border-radius:4px;font-family:monospace;color:#EF4444;font-size:0.9em;">${sel}</code>`);
    syncContent(lc);
}
function toggleHtml(lc) {
    htmlModes[lc] = !htmlModes[lc];
    const ed = document.getElementById('editor-' + lc);
    const htmlEd = document.getElementById('html-editor-' + lc);
    const btn = document.getElementById('html-btn-' + lc);
    if (htmlModes[lc]) {
        htmlEd.value = ed.innerHTML;
        htmlEd.style.display = 'block'; ed.style.display = 'none';
        btn.style.cssText = 'color:#fff;background-color:#1E293B;border-color:#1E293B;';
    } else {
        ed.innerHTML = htmlEd.value;
        ed.style.display = 'block'; htmlEd.style.display = 'none';
        btn.style.cssText = 'color:#64748B;background-color:#fff;border-color:#E2E8F0;';
    }
}

// Sync all editors on submit
document.getElementById('article-form').addEventListener('submit', function () {
    LOCALES.forEach(lc => {
        if (!htmlModes[lc]) {
            const htmlEd = document.getElementById('html-editor-' + lc);
            htmlEd.value = document.getElementById('editor-' + lc).innerHTML;
            htmlEd.style.display = 'block';
        }
    });
});

// ===== Auto Slug (from ID title only) =====
function autoSlug() {
    const title = document.getElementById('art-title-id').value;
    const slug = document.getElementById('art-slug');
    if (!slug.dataset.manual) {
        slug.value = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    }
}
const slugEl = document.getElementById('art-slug');
if (slugEl) slugEl.addEventListener('input', function() { this.dataset.manual = '1'; });

// ===== Image Preview =====
function previewImg(input, targetId) {
    const tgt = document.getElementById(targetId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { tgt.src = e.target.result; tgt.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    } else { tgt.src = ''; tgt.style.display = 'none'; }
}

// ===== Add FAQ per locale =====
function addFaq(lc) {
    const isRTL = (lc === 'ar');
    const list = document.getElementById('faq-list-' + lc);
    const idx = list.children.length;
    const dir = isRTL ? 'rtl' : 'ltr';
    const qPlaceholder = isRTL ? 'سؤال...' : 'Pertanyaan...';
    const aPlaceholder = isRTL ? 'إجابة...' : 'Jawaban...';
    const closePos = isRTL ? 'left' : 'right';
    const html = `
        <div class="faq-item" style="background:#F8FAFC;border:1px solid #E2E8F0;padding:1.25rem;border-radius:12px;position:relative;" dir="${dir}">
            <button type="button" onclick="this.closest('.faq-item').remove()" style="position:absolute;top:1rem;${closePos}:1rem;background:none;border:none;color:#94A3B8;cursor:pointer;padding:0;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <input type="text" name="translations[${lc}][faqs][${idx}][q]" class="form-input" placeholder="${qPlaceholder}" style="margin-bottom:.75rem;background:#fff;" dir="${dir}">
            <textarea name="translations[${lc}][faqs][${idx}][a]" class="form-textarea" rows="2" placeholder="${aPlaceholder}" style="background:#fff;" dir="${dir}"></textarea>
        </div>`;
    list.insertAdjacentHTML('beforeend', html);
}

// ===== Translation completeness check =====
function updateCompleteness() {
    const bar = document.getElementById('trans-progress-bar');
    bar.innerHTML = '';
    LOCALES.forEach(lc => {
        const title = document.getElementById('art-title-' + lc)?.value.trim();
        const content = document.getElementById('html-editor-' + lc)?.value.trim() ||
                        document.getElementById('editor-' + lc)?.innerHTML.replace(/<[^>]+>/g,'').trim();
        const done = !!(title && content);
        const dot = document.getElementById('dot-' + lc);
        if (dot) dot.classList.toggle('filled', done);
        const localeLabels = {'id':'🇮🇩 ID','en':'🇬🇧 EN','ar':'🇸🇦 AR','ko':'🇰🇷 KO'};
        const el = document.createElement('span');
        el.className = 'trans-progress-item' + (done ? ' done' : '');
        el.textContent = (done ? '✓ ' : '– ') + localeLabels[lc];
        bar.appendChild(el);
    });
}
// Run on every input
document.getElementById('article-form').addEventListener('input', updateCompleteness);
// Run on init
setTimeout(updateCompleteness, 100);
</script>
@endpush
@endsection
