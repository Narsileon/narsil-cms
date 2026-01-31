import { Select } from "@base-ui/react/select";
import { Icon } from "@narsil-cms/blocks/icon";

function SelectIcon({ children, render, ...props }: Select.Icon.Props) {
  return (
    <Select.Icon
      data-slot="select-icon"
      render={
        render ?? (
          <Icon
            className="pointer-events-none size-4 text-muted-foreground"
            name={"chevron-down"}
          />
        )
      }
      {...props}
    />
  );
}

export default SelectIcon;
