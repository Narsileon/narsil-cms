import { type ComponentProps } from "react";

import {
  CheckboxIndicator,
  CheckboxRoot,
} from "@narsil-cms/components/checkbox";
import { Icon } from "@narsil-cms/components/icon";
import { type IconName } from "@narsil-cms/plugins/icons";

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
