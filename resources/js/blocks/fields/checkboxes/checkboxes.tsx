import { Checkbox } from "@narsil-cms/blocks/fields/checkbox";
import { useLocalization } from "@narsil-cms/components/localization";
import {
  TableBody,
  TableCell,
  TableRoot,
  TableRow,
  TableWrapper,
} from "@narsil-cms/components/table";
import type { GroupedSelectOption, SelectOption, UniqueIdentifier } from "@narsil-cms/types";

type CheckboxesProps = {
  options: (GroupedSelectOption | SelectOption)[];
  values: UniqueIdentifier[];
  onChange: (value: UniqueIdentifier[]) => void;
};

function Checkboxes({ options, values, onChange }: CheckboxesProps) {
  const { trans } = useLocalization();

  function toggleValue(value: UniqueIdentifier) {
    if (values.includes(value)) {
      onChange(values.filter((x) => x !== value));
    } else {
      onChange([...values, value]);
    }
  }

  function renderCheckboxes(options: (GroupedSelectOption | SelectOption)[]): React.ReactNode {
    const checkboxes = options.flatMap((option) => option.value) as UniqueIdentifier[];

    const checkedCheckboxes = checkboxes.filter((value) =>
      values.includes(value as UniqueIdentifier),
    );

    const allChecked = checkedCheckboxes.length === checkboxes.length;
    const someChecked = checkedCheckboxes.length > 0 && !allChecked;

    const toggleAll = () => {
      if (allChecked) {
        onChange(values.filter((value) => !checkboxes.includes(value)));
      } else {
        onChange(Array.from(new Set<UniqueIdentifier>([...values, ...checkboxes])));
      }
    };

    return (
      <>
        <TableRow className="border-b-2 bg-accent">
          <TableCell>
            <div className="flex items-center justify-start gap-2">
              <Checkbox
                checked={allChecked ? true : someChecked ? "indeterminate" : false}
                onCheckedChange={toggleAll}
              />
              <label>{trans("ui.all")}</label>
            </div>
          </TableCell>
        </TableRow>

        {options.flatMap((option) => {
          if ("options" in option) {
            return renderCheckboxes(option.options as (GroupedSelectOption | SelectOption)[]);
          } else {
            const checked = values.includes(option.value);

            return (
              <TableRow key={option.value}>
                <TableCell>
                  <div className="flex items-center justify-start gap-2">
                    <Checkbox checked={checked} onCheckedChange={() => toggleValue(option.value)} />
                    <label>{option.label as string}</label>
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
    <TableWrapper>
      <TableRoot>
        <TableBody>{renderCheckboxes(options)}</TableBody>
      </TableRoot>
    </TableWrapper>
  );
}

export default Checkboxes;
