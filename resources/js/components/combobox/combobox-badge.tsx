import { BadgeRoot } from "@narsil-cms/components/badge";
import { Icon } from "@narsil-cms/components/icon";
import { getSelectOption } from "@narsil-cms/lib/utils";
import { type SelectOption } from "@narsil-cms/types";

type ComboboxBadgeProps = React.ComponentProps<typeof BadgeRoot> & {
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
    <BadgeRoot>
      {optionLabel}
      <button
        type="button"
        onClick={(event) => {
          event.stopPropagation();

          setValue(value.filter((x) => x !== optionValue));
        }}
        className="hover:text-destructive focus:outline-none"
      >
        <Icon name="x" className="h-3 w-3" />
      </button>
    </BadgeRoot>
  );
}

export default ComboboxBadge;
