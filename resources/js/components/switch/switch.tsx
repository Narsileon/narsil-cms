import { SwitchRoot, SwitchThumb } from "@narsil-cms/components/switch";
import { type ComponentProps } from "react";

type SwitchProps = ComponentProps<typeof SwitchRoot>;

function Switch({ ...props }: SwitchProps) {
  return (
    <SwitchRoot {...props}>
      <SwitchThumb />
    </SwitchRoot>
  );
}

export default Switch;
