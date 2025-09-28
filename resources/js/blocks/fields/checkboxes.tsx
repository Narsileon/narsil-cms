import { useLabels } from "@narsil-cms/components/labels";
import {
  TableBody,
  TableCell,
  TableRoot,
  TableRow,
} from "@narsil-cms/components/table";
import type {
  GroupedSelectOption,
  SelectOption,
  UniqueIdentifier,
} from "@narsil-cms/types";

import Checkbox from "./checkbox";

type CheckboxesProps = {
  options: (GroupedSelectOption | SelectOption)[];
  values: UniqueIdentifier[];
  onChange: (value: UniqueIdentifier[]) => void;
};

function Checkboxes({ options, values, onChange }: CheckboxesProps) {
  const { trans } = useLabels();

  function toggleValue(value: UniqueIdentifier) {
    if (values.includes(value)) {
      onChange(values.filter((x) => x !== value));
    } else {
      onChange([...values, value]);
    }
  }

  function renderCheckboxes(
    options: (GroupedSelectOption | SelectOption)[],
  ): React.ReactNode {
    const checkboxes = options.flatMap(
      (option) => option.value,
    ) as UniqueIdentifier[];

    const checkedCheckboxes = checkboxes.filter((value) =>
      values.includes(value as UniqueIdentifier),
    );

    const allChecked = checkedCheckboxes.length === checkboxes.length;
    const someChecked = checkedCheckboxes.length > 0 && !allChecked;

    const toggleAll = () => {
      if (allChecked) {
        onChange(values.filter((value) => !checkboxes.includes(value)));
      } else {
        onChange(
          Array.from(new Set<UniqueIdentifier>([...values, ...checkboxes])),
        );
      }
    };

    return (
      <>
        <TableRow>
          <TableCell>
            <div className="flex items-center justify-start gap-2">
              <Checkbox
                checked={
                  allChecked ? true : someChecked ? "indeterminate" : false
                }
                onCheckedChange={toggleAll}
              />
              <label>{trans("ui.all")}</label>
            </div>
          </TableCell>
        </TableRow>

        {options.flatMap((option) => {
          if ("options" in option) {
            return renderCheckboxes(
              option.options as (GroupedSelectOption | SelectOption)[],
            );
          } else {
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
          }
        })}
      </>
    );
  }

  return (
    <div className="overflow-hidden rounded-md border">
      <TableRoot>
        <TableBody>{renderCheckboxes(options)}</TableBody>
      </TableRoot>
    </div>
  );
}

export default Checkboxes;
