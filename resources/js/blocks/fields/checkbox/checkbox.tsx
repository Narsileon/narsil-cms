import { Icon } from "@narsil-cms/blocks/icon";
import { CheckboxIndicator, CheckboxRoot } from "@narsil-cms/components/checkbox";
import { type IconName } from "@narsil-cms/repositories/icons";
import { type ComponentProps } from "react";

type CheckboxProps = ComponentProps<typeof CheckboxRoot> & {
  icon?: IconName;
  indicatorProps?: Partial<ComponentProps<typeof CheckboxIndicator>>;
};

function Checkbox({ icon = "check", indicatorProps, ...props }: CheckboxProps) {
  return (
    <CheckboxRoot {...props}>
      <CheckboxIndicator {...indicatorProps}>
        <Icon className="size-3.5 text-current" name={icon} />
      </CheckboxIndicator>
    </CheckboxRoot>
  );
}

export default Checkbox;
