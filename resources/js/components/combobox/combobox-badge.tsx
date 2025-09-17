import { Badge } from "@narsil-cms/blocks";
import { getSelectOption } from "@narsil-cms/lib/utils";
import { type SelectOption } from "@narsil-cms/types";

type ComboboxBadgeProps = React.ComponentProps<typeof Badge> & {
  displayValue?: boolean;
  item: SelectOption | string;
  value: string[];
  labelPath: string;
  valuePath: string;
  setValue: (value: string[]) => void;
};

function ComboboxBadge({
  item,
  labelPath,
  value,
  valuePath,
  setValue,
}: ComboboxBadgeProps) {
  const optionLabel = getSelectOption(item, labelPath);
  const optionValue = getSelectOption(item, valuePath);

  return (
    <Badge onClose={() => setValue(value.filter((x) => x !== optionValue))}>
      {optionLabel}
    </Badge>
  );
}

export default ComboboxBadge;
