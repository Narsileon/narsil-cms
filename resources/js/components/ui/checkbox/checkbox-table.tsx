import * as React from "react";
import { Table, TableBody, TableCell, TableRow } from "../table";
import Checkbox from "./checkbox";
import type { GroupedSelectOption } from "@narsil-cms/types/forms";

type CheckboxTableProps = {
  options: GroupedSelectOption[];
  values: any[];
  setValues: (values: any[]) => void;
};

function CheckboxTable({
  options,
  values,
  setValues,
  ...props
}: CheckboxTableProps) {
  const toggleValue = (value: any) => {
    if (values.includes(value)) {
      setValues(values.filter((x) => x !== value));
    } else {
      setValues([...values, value]);
    }
  };

  return (
    <div className="overflow-hidden rounded-md border">
      <Table>
        <TableBody>
          {options.map((option) => {
            const checked = values.includes(option.value);

            return (
              <TableRow key={option.value}>
                <TableCell>
                  <div className="flex items-center justify-start gap-2">
                    <Checkbox
                      checked={checked}
                      onCheckedChange={() => toggleValue(option.value)}
                    />
                    <label>{option.label}</label>
                  </div>
                </TableCell>
              </TableRow>
            );
          })}
        </TableBody>
      </Table>
    </div>
  );
}

export default CheckboxTable;
