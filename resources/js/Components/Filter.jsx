import react from "react";
import Button from "./Button";
import { HiFilter } from "react-icons/hi";

export function Filter({ className, label }) {
    return (
        <div className={className}>
            <button
                className="mr-3 text-gray-800 bg-white hover:bg-gray-400 font-medium rounded-md text-sm px-5 py-2.5 flex space-x-3  items-center"
                type="button"
                id="dropdownDefault"
                data-dropdown-toggle="dropdown"
            >
                <HiFilter />
                <span>{label}</span>
            </button>
            <div
                id="dropdown"
                className="z-10 hidden w-56 p-3 bg-white rounded-lg shadow dark:bg-gray-700"
            >
                <ul
                    className="space-y-2 text-sm"
                    aria-labelledby="dropdownDefault"
                >
                    <li>Name</li>
                </ul>
            </div>
        </div>
    );
}
