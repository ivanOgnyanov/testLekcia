<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use App\Services\MemberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Ресурсен контролер за членовете (лекция 5, слайдове 36-51).
 *
 * Създаден с: php artisan make:model Member -mfsc --resource --requests
 */
class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('members.index', [
            'members' => Member::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * Валидацията (StoreMemberRequest) е минала преди методът да започне.
     * Записът и имейлът са в MemberService - контролерът е тънък (слайд 13).
     */
    public function store(StoreMemberRequest $request, MemberService $members): RedirectResponse
    {
        $members->register($request->validated());

        return redirect()->route('members.index')
            ->with('success', 'Членът е добавен успешно.');
    }

    /**
     * Display the specified resource.
     *
     * Route model binding: {member} в адреса → обект Member (или 404).
     */
    public function show(Member $member): View
    {
        return view('members.show', ['member' => $member]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member): View
    {
        return view('members.edit', ['member' => $member]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member): RedirectResponse
    {
        $member->update($request->validated());

        return redirect()->route('members.index')
            ->with('success', 'Данните са обновени успешно.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Членът е изтрит.');
    }
}
