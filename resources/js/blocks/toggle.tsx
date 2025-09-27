import { type ComponentProps } from "react";

import { ToggleRoot } from "@narsil-cms/components/toggle";

import Tooltip from "./tooltip";

type ToggleProps = ComponentProps<typeof ToggleRoot> & {
  tooltip?: string;
  tooltipProps?: ComponentProps<typeof Tooltip>;
};

function Toggle({ tooltip, tooltipProps, ...props }: ToggleProps) {
  const tooltipLabel = tooltip || tooltipProps?.tooltip;

  if (!tooltipLabel) {
    return <ToggleRoot {...props} />;
  }
  return (
    <Tooltip tooltip={tooltipLabel} {...tooltipProps}>
      <ToggleRoot aria-label={tooltipLabel as string} {...props} />
    </Tooltip>
  );
}

export default Toggle;
