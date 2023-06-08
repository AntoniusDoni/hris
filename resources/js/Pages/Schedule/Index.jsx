import React, { useEffect, useState } from 'react';
import { router } from '@inertiajs/react';
import { usePrevious } from 'react-use';
import { Head } from '@inertiajs/react';
import { Button, Dropdown } from 'flowbite-react';
import { HiPencil, HiTrash } from 'react-icons/hi';
import { useModalState } from '@/hooks';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Pagination from '@/Components/Pagination';
import ModalConfirm from '@/Components/ModalConfirm';
import FormModal from './FormModal';
import SearchInput from '@/Components/SearchInput';
import { hasPermission } from '@/utils';

export default function Index(props) {
    const { query: { links, data }, auth } = props
    
    const [search, setSearch] = useState('')
    const preValue = usePrevious(search)

    const confirmModal = useModalState()
    const formModal = useModalState()

    const toggleFormModal = (schedule = null) => {
        formModal.setData(schedule)
        formModal.toggle()
    }

    const handleDeleteClick = (schedule) => {
        confirmModal.setData(schedule)
        confirmModal.toggle()
    }

    const onDelete = () => {
        if(confirmModal.data !== null) {
            router.delete(route('scheduler.destroy', confirmModal.data.id))
        }
    }

    const params = { q: search }
    useEffect(() => {
        if (preValue) {
            router.get(
                route(route().current()),
                { q: search },
                {
                    replace: true,
                    preserveState: true,
                }
            )
        }
    }, [search])

    const canCreate = hasPermission(auth, 'create-schedule')
    const canUpdate = hasPermission(auth, 'update-schedule')
    const canDelete = hasPermission(auth, 'delete-schedule')
    
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Dashboard'}
            action={'Jadwal'}
        >
            <Head title="Jadwal"/>

            <div>
                <div className="mx-auto sm:px-6 lg:px-8 ">
                    <div className="p-6 overflow-hidden shadow-sm sm:rounded-lg bg-gray-200 dark:bg-gray-800 space-y-4">
                        <div className='flex justify-between'>
                            {canCreate && (
                                <Button size="sm" onClick={() => toggleFormModal()}>Tambah</Button>
                            )}
                            <div className="flex items-center">
                                <SearchInput
                                    onChange={e => setSearch(e.target.value)}
                                    value={search}
                                />
                            </div>
                        </div>
                        <div className='overflow-auto'>
                            <div>
                                <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                           
                                            <th scope="col" className="py-3 px-6">
                                                Name
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Jam Masuk
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Jam Keluar
                                            </th>
                                            <th scope="col" className="py-3 px-6"/>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {data.map(schedule => (
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={schedule.id}>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {schedule.name}
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {schedule.start_in}
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {schedule?.end_out}
                                                </td>
                                              
                                                <td className="py-4 px-6 flex justify-end">
                                                    <Dropdown
                                                        label={"Opsi"}
                                                        floatingArrow={true}
                                                        arrowIcon={true}
                                                        dismissOnClick={true}
                                                        size={'sm'}
                                                    >
                                                        {canUpdate && (
                                                            <Dropdown.Item onClick={() => toggleFormModal(schedule)}>
                                                                <div className='flex space-x-1 items-center'>
                                                                    <HiPencil/> 
                                                                    <div>Ubah</div>
                                                                </div>
                                                            </Dropdown.Item>
                                                        )}
                                                        {canDelete && (
                                                            <Dropdown.Item onClick={() => handleDeleteClick(schedule)}>
                                                                <div className='flex space-x-1 items-center'>
                                                                    <HiTrash/> 
                                                                    <div>Hapus</div>
                                                                </div>
                                                            </Dropdown.Item>
                                                        )}
                                                    </Dropdown>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                            <div className='w-full flex items-center justify-center'>
                                <Pagination links={links} params={params}/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ModalConfirm
                modalState={confirmModal}
                onConfirm={onDelete}
            />
            <FormModal
                modalState={formModal}
            />
        </AuthenticatedLayout>
    );
}