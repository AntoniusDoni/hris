import React, { useEffect } from "react";
import { Head, Link, router, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Button from "@/Components/Button";
import SelectedInputDevision from "../Division/SelectionInput";
import SeletedInputPosition from "../Position/SelectionInput";
import SelectEmployee from "../Employee/SelectionInput";
import SelectInputSchedule from "../Schedule/SelectionInput";
import { isEmpty } from "lodash";
import FormInputDate from "@/Components/FormInputDate";
import routes from "@/Layouts/Partials/routes";

export default function Form(props) {
    const { employeeScheduler, month } = props;
    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            employee_id: "",
            division_id: "",
            position_id: "",
            schedules_id: "",
            date: "",
            long_day: 5,
            employee_var: 0,
            is_employee: false,
            detail_month: "",
        });
    const handleOnChange = (event) => {
        setData(
            event.target.name,
            event.target.type === "checkbox"
                ? event.target.checked
                    ? 1
                    : 0
                : event.target.value
        );
    };
    const handleOnChangeEmployee = (event) => {
        if (event.target.value == 1) {
            setData({
                ...data,
                employee_var: event.target.value,
                is_employee: true,
                division_id: data.division_id,
                position_id: data.position_id,
                schedules_id: data.schedules_id,
                long_day: data.long_day,
                date: data.date,
                // is_employee: data.is_employee,
                detail_month: data.detail_month,
            });
        } else {
            setData({
                ...data,
                employee_var: event.target.value,
                is_employee: false,
                division_id: data.division_id,
                position_id: data.position_id,
                schedules_id: data.schedules_id,
                long_day: data.long_day,
                date: data.date,
                employee_id: "",
                detail_month: data.detail_month,
            });
        }
    };
    const handleSubmit = () => {
        if (isEmpty(employeeScheduler) === false) {
            put(route("employee-scheduler.update", employeeScheduler));
            return;
        }
        post(route("employee-scheduler.store"), {
            onSuccess: () => reset(),
        });
    };
    useEffect(() => {
        if (isEmpty(employeeScheduler) === false) {
            let timeStamp = Date.parse(employeeScheduler.date);
            var day = new Date(timeStamp);
            var getmonth = day.getMonth() + 1;

            setData({
                employee_id: employeeScheduler.employee_id,
                division_id: employeeScheduler.division_id,
                position_id: employeeScheduler.position_id,
                schedules_id: employeeScheduler.schedules_id,
                date: employeeScheduler.date,
                long_day: 1,
                employee_var: 1,
                is_employee: true,
                detail_month: getmonth,
            });
        }
    }, [employeeScheduler]);

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Dashboard"}
            action={"Jadwal Pegawai"}
        >
            <Head title={"Jadwal Pegawai"} />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className="text-xl mb-4">Jadwal Pegawai</div>
                        <div className="flex">
                            <div className="flex-auto px-2">
                                <SelectedInputDevision
                                    label="Divisi"
                                    itemSelected={data.division_id}
                                    onItemSelected={(id) =>
                                        setData("division_id", id)
                                    }
                                    error={errors.division_id}
                                />
                            </div>
                            <div className="flex-auto px-2">
                                <SeletedInputPosition
                                    label="Jabatan"
                                    itemSelected={data.position_id}
                                    onItemSelected={(id) =>
                                        setData("position_id", id)
                                    }
                                    error={errors.position_id}
                                />
                            </div>
                            <div className="flex-auto px-2">
                                <SelectInputSchedule
                                    label="Jadwal"
                                    itemSelected={data.schedules_id}
                                    onItemSelected={(id) =>
                                        setData("schedules_id", id)
                                    }
                                    error={errors.schedules_id}
                                />
                            </div>
                            <div className="flex-auto px-2">
                                <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Jenis Pegawai
                                </label>
                                <select
                                    className="mb-2 bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white"
                                    name="employee_var"
                                    onChange={handleOnChangeEmployee}
                                    value={data.employee_var}
                                >
                                    {employeeScheduler == null && (
                                        <option value={"0"}>
                                            -- Semua Peagawai --
                                        </option>
                                    )}
                                    <option value={"1"}>Pilih Pegawai</option>
                                </select>
                            </div>
                        </div>
                        <div className="flex">
                            <div className="flex-auto px-2">
                                <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Jumlah Hari Kerja
                                </label>
                                <select
                                    className="mb-2 bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white"
                                    name="long_day"
                                    onChange={handleOnChange}
                                    value={data.long_day}
                                >
                                    <option value={"1"}>
                                        Berdasarkan Tanggal{" "}
                                    </option>
                                    {employeeScheduler == null && (
                                        <>
                                            <option value={"5"}>5 Hari </option>
                                            <option value={"6"}>6 Hari</option>
                                        </>
                                    )}
                                </select>
                            </div>
                            <div className="flex-auto px-2">
                                <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Bulan
                                </label>
                                <select
                                    className="mb-2 bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white"
                                    name="detail_month"
                                    onChange={handleOnChange}
                                    value={data.detail_month}
                                >
                                    <option value={""}>
                                        -- Pilih Bulan --
                                    </option>
                                    {month.map((m, index) => (
                                        <option value={index + 1} key={index}>
                                            {m}
                                        </option>
                                    ))}
                                </select>
                                {errors.detail_month && (
                                    <p className="mb-2 text-sm text-red-600 dark:text-red-500">
                                        {errors.detail_month}
                                    </p>
                                )}
                            </div>
                            {data.is_employee == true && (
                                <div className="flex-auto px-2">
                                    <SelectEmployee
                                        label="Pegawai"
                                        itemSelected={data.employee_id}
                                        onItemSelected={(id) =>
                                            setData("employee_id", id)
                                        }
                                        error={errors.employee_id}
                                    />
                                </div>
                            )}
                            {data.long_day == 1 && (
                                <FormInputDate
                                    name="date_out"
                                    selected={data.date}
                                    onChange={(date) => setData("date", date)}
                                    label="Tanggal"
                                    error={errors.date}
                                />
                            )}
                        </div>

                        <div className="mt-10">
                            <Button
                                onClick={handleSubmit}
                                processing={processing}
                            >
                                Simpan
                            </Button>
                            <Button
                                onClick={() => router.visit(route("employee-scheduler.index"))} 
                                // processing={processing}
                                type="secondary"
                            >
                                Batal
                            </Button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
