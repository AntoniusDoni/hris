import React, { useEffect, useState } from "react";
import { Link, router } from "@inertiajs/react";
import { usePrevious } from "react-use";
import { Head } from "@inertiajs/react";
import { Button, Dropdown } from "flowbite-react";
import { HiPencil, HiTrash } from "react-icons/hi";
import { useModalState } from "@/hooks";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Pagination from "@/Components/Pagination";
import ModalConfirm from "@/Components/ModalConfirm";
import FormModal from "./FormModal";
import SearchInput from "@/Components/SearchInput";
import { hasPermission } from "@/utils";
import { Filter } from "@/Components/Filter";

export default function Index(props) {
    const {
        query: { links, data },
        auth,
    } = props;

    const [search, setSearch] = useState("");
    const preValue = usePrevious(search);

    const confirmModal = useModalState();
    const formModal = useModalState();

    const toggleFormModal = (attendance = null) => {
        formModal.setData(attendance);
        formModal.toggle();
    };

    const handleDeleteClick = (attendance) => {
        confirmModal.setData(attendance);
        confirmModal.toggle();
    };

    const onDelete = () => {
        if (confirmModal.data !== null) {
            router.delete(route("attendance.destroy", confirmModal.data.id));
        }
    };

    const params = { q: search };
    useEffect(() => {
        if (preValue) {
            router.get(
                route(route().current()),
                { q: search },
                {
                    replace: true,
                    preserveState: true,
                }
            );
        }
    }, [search]);

    // const canCreate = hasPermission(auth, "create-leave");
    const canUpdate = hasPermission(auth, "update-leave");
    const canDelete = hasPermission(auth, "delete-leave");

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Dashboard"}
            action={"Cuti Pegawai"}
        >
            <Head title="Cuti Pegawai" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8 ">
                    <div className="p-6 overflow-hidden shadow-sm sm:rounded-lg bg-gray-200 dark:bg-gray-800 space-y-4">
                        <div className="flex">
                            {/* <div className="flex">
                                {canCreate && (
                                    <Button
                                        size="sm"
                                        onClick={() => toggleFormModal()}
                                    >
                                        Tambah
                                    </Button>
                                )}
                            </div> */}
                            <div className="flex-auto flex justify-end">
                                <Filter
                                    className={"content-end"}
                                    label="Filter"
                                />
                                <div className="content-end">
                                    <SearchInput
                                        onChange={(e) =>
                                            setSearch(e.target.value)
                                        }
                                        value={search}
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="overflow-auto">
                            <div>
                                <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>

                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                NIP
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Name
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Divisi
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Jabatan
                                            </th>

                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Tgl Mulai
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Tgl Selesai
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Disetujui
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Penangung Jawab
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            />
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {data.map((leave) => (
                                            <tr
                                                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                                key={leave.id}
                                            >

                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {leave?.employee?.nip}
                                                </td>
                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {leave?.employee?.name}
                                                </td>
                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {
                                                        leave?.employee?.division?.name
                                                    }
                                                </td>
                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {
                                                        leave?.employee?.position?.name
                                                    }
                                                </td>

                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {leave?.date_start}
                                                </td>
                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {leave?.date_end}
                                                </td>
                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {leave?.is_approve===1?'Disetujui':'-'}
                                                </td>
                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {leave?.responsible_employee?.name}
                                                </td>
                                                <td className="py-4 px-6 flex justify-end">
                                                    <Dropdown
                                                        label={"Opsi"}
                                                        floatingArrow={true}
                                                        arrowIcon={true}
                                                        dismissOnClick={true}
                                                        size={"sm"}
                                                    >
                                                        {canUpdate && (
                                                            <Dropdown.Item
                                                                onClick={() =>
                                                                    toggleFormModal(
                                                                        leave
                                                                    )
                                                                }
                                                            >
                                                                <div className="flex space-x-1 items-center">
                                                                    <HiPencil />
                                                                    <div>
                                                                        Ubah
                                                                    </div>
                                                                </div>
                                                            </Dropdown.Item>
                                                        )}
                                                        {canDelete && (
                                                            <Dropdown.Item
                                                                onClick={() =>
                                                                    handleDeleteClick(
                                                                        leave
                                                                    )
                                                                }
                                                            >
                                                                <div className="flex space-x-1 items-center">
                                                                    <HiTrash />
                                                                    <div>
                                                                        Hapus
                                                                    </div>
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
                            <div className="w-full flex items-center justify-center">
                                <Pagination links={links} params={params} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ModalConfirm modalState={confirmModal} onConfirm={onDelete} />
            <FormModal modalState={formModal} />
        </AuthenticatedLayout>
    );
}