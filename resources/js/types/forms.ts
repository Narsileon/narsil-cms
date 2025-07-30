import type { IconName } from "lucide-react/dynamic";

export type Field = {
  conditions?: BlockElementCondition[] | null;
  description?: string;
  handle: string;
  icon?: IconName;
  id: number;
  name: string;
  settings?: Record<string, any>;
  type: string;
  visibility?: "display" | "display_when" | "hidden" | "hidden_when";
};

export type BlockElementCondition = {
  operator: string;
  target_id: string;
  value: string;
};

export type Block = {
  elements: (Field | Block)[];
  handle: string;
  id: number;
  name: string;
};

export type FormType = {
  elements: (Field | Block)[];
  id: string;
  method: string;
  submit: string;
  url: string;
};

export type SelectOption = {
  [key: string]: any;
  label: string;
  value: any;
} & {
  options?: SelectOption[]; // Grouped select options
};
