import * as React from "react";
import { Badge } from "@narsil-cms/components/badge";
import { getSelectOption } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";
import type { SelectOption } from "@narsil-cms/types/forms";

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
    <Badge>
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
    </Badge>
  );
}

export default ComboboxBadge;
