export type Block = {
  elements: BlockElement[];
  handle: string;
  id: number;
  name: string;
};

export type BlockElement = {
  blocks: Block[];
  conditions: BlockElementCondition[];
  description: string | null;
  element: Block | Field;
  fields: Field[];
  handle: string | null;
  id: number;
  name: string | null;
  position: number;
  settings: Record<string, any> | null;
};

export type BlockElementCondition = {
  id: number;
  operator: string;
  owner_id: number;
  target_id: number;
  value: string;
};

export type Field = {
  description: string | null;
  handle: string;
  id: number;
  name: string;
  settings: Record<string, any>;
  type: string;
};

export type FormType = {
  elements: (Block | Field)[];
  id: string;
  method: string;
  submit: string;
  url: string;
};

export type GroupedSelectOption = {
  [key: string]: any;
  label: string;
} & {
  options: SelectOption[];
};

export type SelectOption = {
  [key: string]: any;
  label: string;
  value: any;
};
